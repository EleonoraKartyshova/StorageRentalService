<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Form\LoginType;
use Symfony\Component\Form\NativeRequestHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;
use App\Form\ProfileType;
use Symfony\Component\Form\ClearableErrorsInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends FrontController
{
    const IMAGES_DIR = 'images/';

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );
        }
        return $this->render('page/registration.html.twig', array(
            'reg_form' => $form->createView(),
            'registration' => 'active',
        ));
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginType::class);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('page/login.html.twig', [
            'last_login' => $lastUsername,
            'error' => $error,
            'login_form' => $form->createView(),
            'login' => 'active',
            ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @Route("/profile/show", name="show_profile")
     */
    public function showProfile()
    {
        return $this->render('page/profile.html.twig', [
            'profile' => 'active',
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @Route("/profile/edit", name="edit_profile")
     */
    public function editProfile(Request $request, Security $security)
    {
        $form = $this->createForm(ProfileType::class);

        $authUser = $security->getUser();

        if ($request->request->get('removeUserProfilePhoto')) {
            unlink(self::IMAGES_DIR . $authUser->getPhoto());

            $authUser->setPhoto(null);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('edit_profile');
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $this->validateNonUniqueFields($form)) {
            $formData = $form->getData();

            $formDataLogin = $formData->getLogin();
            $formDataPassword = $formData->getPassword();
            $formDataCompanyTitle = $formData->getCompanyTitle();
            $formDataPhoneNumber = $formData->getPhoneNumber();
            $formDataName = $formData->getName();
            $formDataAddress = $formData->getAddress();

            $file = $form['photo']->getData();

            if (!empty($file)) {
                $filename = $file->getClientOriginalName();

                $file->move(self::IMAGES_DIR, $filename);

                $authUser->setPhoto($filename);
            }

            if ($formDataLogin !== $authUser->getLogin() && $form->get('login')->isValid()) {
                $authUser->setLogin($formDataLogin);
            } elseif ($formDataLogin === $authUser->getLogin()) {
                $form->clearErrors(true);
            } elseif ($formDataLogin !== $authUser->getLogin() && $form->get('login')->isValid() == false) {
                return $this->render('page/edit_profile.html.twig', [
                    'profile' => 'active',
                    'profile_user_form' => $form->createView(),
                ]);
            }

            $authUser->setPassword($formDataPassword);
            $authUser->setCompanyTitle($formDataCompanyTitle);
            $authUser->setPhoneNumber($formDataPhoneNumber);
            $authUser->setName($formDataName);
            $authUser->setAddress($formDataAddress);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('edit_profile');
        }
        return $this->render('page/edit_profile.html.twig', [
            'profile' => 'active',
            'profile_user_form' => $form->createView(),
        ]);
    }

    private function validateNonUniqueFields($form)
    {
        return $form->get('password')->isValid() &&
            $form->get('companyTitle')->isValid() &&
            $form->get('phoneNumber')->isValid() &&
            $form->get('name')->isValid() &&
            $form->get('address')->isValid() && $form->get('photo')->isValid();
    }
}
