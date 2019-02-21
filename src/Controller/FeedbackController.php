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
    public function feedback(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(FeedbackType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();

            $message = (new \Swift_Message())
                ->setSubject('Feedback message')
                ->setFrom($feedback->getEmail())
                ->setTo('eleonora.testmailer@gmail.com')
                ->setBody(
                    $this->renderView('page/feedback_mail.html.twig', [
                        'subject' => $feedback->getSubject(),
                        'text' => $feedback->getText(),
                        'email' => $feedback->getEmail(),
                        'name' => $feedback->getName(),
                    ]),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Message was sent successfully!');

            return $this->redirectToRoute('contact_us');
        }
        return $this->render('page/contact_us.html.twig', array(
            'feedback_form' => $form->createView(),
            'contact_us' => 'active',
        ));
    }
}
