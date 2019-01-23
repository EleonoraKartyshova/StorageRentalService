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


class UserController extends BaseController
{
    protected $isAuth;
    protected $role;
    protected $login;

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Saved!');
            return $this->redirectToRoute('registration');
        }
        return $this->render('page/registration.html.twig', array(
            'reg_form' => $form->createView(),
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy([
                'login' => $data->getLogin(),
                'password' => $data->getPassword(),
            ]);
            if ($user) {
                return $this->render('page/about_us.html.twig', [
                    'header' => 'header/auth_header.html.twig',
                    'about_us' => 'active',
                    'user_login'=> $user->getLogin()
                ]);
            }
        }
        return $this->render('page/login.html.twig', array(
            'login_form' => $form->createView(),
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $form = $this->createForm(LoginType::class);
        return $this->render('page/login.html.twig', array(
            'login_form' => $form->createView(),
        ));
    }
}
