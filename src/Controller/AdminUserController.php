<?php

namespace App\Controller;

use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\ClearableErrorsInterface;

class AdminUserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/users", name="admin_users")
     */
    public function getAllUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('page/admin_users_list.html.twig', [
            'admin' => 'active',
            'users' => $users
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/deactivate_user/{id}", name="admin_deactivate_user", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function deactivateUser($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'id' => $id,
            ]);
        if ($request->request->get('deactivateUser')) {
            $user->setIsActive('0');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_users');
        }
        return $this->render('page/admin_deactivate_user.html.twig', [
                'admin' => 'active',
                'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/activate_user/{id}", name="admin_activate_user", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function activateUser($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'id' => $id,
            ]);
        if ($request->request->get('activateUser')) {
            $user->setIsActive('1');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_users');
        }
        return $this->render('page/admin_activate_user.html.twig', [
            'admin' => 'active',
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/edit_user/{id}", name="admin_edit_user", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function editUser($id, Request $request)
    {
        $form = $this->createForm(EditUserType::class);
        $form->handleRequest($request);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'id' => $id,
            ]);

        if ($form->isSubmitted() && $this->validateNonUniqueFields($form)) {
            $formData = $form->getData();

            $formDataLogin = $formData->getLogin();
            $formDataEmail = $formData->getEmail();
            $formDataPassword = $formData->getPassword();
            $formDataCompanyTitle = $formData->getCompanyTitle();
            $formDataPhoneNumber = $formData->getPhoneNumber();
            $formDataName = $formData->getName();
            $formDataAddress = $formData->getAddress();
            $formDataRole = $formData->getRole();
            $formDataPhoto = $formData->getPhoto();

            if (!empty($formDataPhoto)) {
                $user->setPhoto($formDataPhoto);
            }

            if ($formDataLogin !== $user->getLogin() && $form->get('login')->isValid()) {
                $user->setLogin($formDataLogin);
            } elseif ($formDataLogin === $user->getLogin()) {
                $form->clearErrors(true);
            } elseif ($formDataLogin !== $user->getLogin() && $form->get('login')->isValid() == false) {
                return $this->render('page/admin_edit_user.html.twig', [
                    'admin' => 'active',
                    'edit_user_form' => $form->createView(),
                    'user' => $user,
                ]);
            }

            if ($formDataEmail !== $user->getEmail() && $form->get('email')->isValid()) {
                $user->setEmail($formDataEmail);
            } elseif ($formDataLogin === $user->getLogin()) {
                $form->clearErrors(true);
            } elseif ($formDataEmail !== $user->getEmail() && $form->get('email')->isValid() == false) {
                return $this->render('page/admin_edit_user.html.twig', [
                    'admin' => 'active',
                    'edit_user_form' => $form->createView(),
                    'user' => $user,
                ]);
            }

            $user->setPassword($formDataPassword);
            $user->setCompanyTitle($formDataCompanyTitle);
            $user->setPhoneNumber($formDataPhoneNumber);
            $user->setName($formDataName);
            $user->setAddress($formDataAddress);
            $user->setRole($formDataRole);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_users');
        }
        return $this->render('page/admin_edit_user.html.twig', [
            'admin' => 'active',
            'edit_user_form' => $form->createView(),
            'user' => $user,
        ]);
    }

    private function validateNonUniqueFields($form)
    {
        return $form->get('password')->isValid() &&
            $form->get('companyTitle')->isValid() &&
            $form->get('phoneNumber')->isValid() &&
            $form->get('name')->isValid() &&
            $form->get('address')->isValid() &&
            $form->get('role')->isValid() && $form->get('photo')->isValid();
    }
}
