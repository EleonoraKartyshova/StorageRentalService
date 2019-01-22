<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Form\NativeRequestHandler;


class UserController extends AbstractController
{
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
        return $this->render('user/register.html.twig', array(
            'controller_name' => 'RegController',
            'reg_form' => $form->createView(),
        ));

    }
}
