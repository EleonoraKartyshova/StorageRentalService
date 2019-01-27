<?php

namespace App\Controller;

use App\Entity\Feedback;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FeedbackType;

class FeedbackController extends FrontController
{
    /**
     * @Route("/page/contact_us", name="contact_us")
     */
    public function feedback(Request $request)
    {
        $form = $this->createForm(FeedbackType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Message was sent successfully!');
            return $this->redirectToRoute('contact_us');
        }
        return $this->render('page/contact_us.html.twig', array(
            'feedback_form' => $form->createView(),
            'contact_us' => 'active',
        ));
    }
}
