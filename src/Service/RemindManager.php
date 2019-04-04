<?php
/**
 * Created by PhpStorm.
 * User: eleonora
 * Date: 28.02.19
 * Time: 19:39
 */

namespace App\Service;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemindManager extends AbstractController
{
    protected $daysToEndOfStoragePeriod = 7;
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmails()
    {
        $dateTo = new \DateTime('+'. $this->daysToEndOfStoragePeriod .' days');

        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findBy([
                'dateTo' => $dateTo,
            ]);

        foreach ($reservations as $reservation) {
            $email = $reservation->getUserId()->getEmail();
            $user = $reservation->getUserId()->getName();
            $message = (new \Swift_Message())
                ->setSubject('Storage period will expire soon!')
                ->setFrom('eleonora.testmailer@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView('page/reminder_mail.html.twig', [
                        'name' => $user,
                        'date_interval' => $this->daysToEndOfStoragePeriod,
                    ]),
                    'text/html'
                );

            $this->mailer->send($message);
        }
    }
}
