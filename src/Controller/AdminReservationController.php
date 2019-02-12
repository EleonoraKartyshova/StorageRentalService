<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Entity\StorageType;
use App\Entity\StorageVolume;
use App\Entity\Goods;
use App\Entity\User;
use App\Entity\GoodsProperty;
use App\Entity\Delivery;
use App\Entity\Reservation;
use App\Form\GoodsType;
use App\Form\DeliveryType;
use App\Form\ReservationType;
use App\Form\BaseReservationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminReservationController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/reservations", name="admin_reservations")
     */
    public function getAllReservations()
    {
        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('page/admin_reservations_list.html.twig', [
            'admin' => 'active',
            'reservations' => $reservations
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/reservation_details/{id}", name="admin_reservation_details", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function getReservation($id)
    {
        $reservation = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findOneBy([
                'id' => $id,
            ]);

        if ($reservation->getHasDelivery()) {
            $delivery = $this->getDoctrine()
                ->getRepository(Delivery::class)
                ->findOneBy([
                    'reservationId' => $id,
                ]);

            return $this->render('page/admin_reservation_details.html.twig', [
                'admin' => 'active',
                'reservation' => $reservation,
                'delivery' => $delivery,
            ]);
        } else {
            return $this->render('page/admin_reservation_details.html.twig', [
                'admin' => 'active',
                'reservation' => $reservation,
            ]);
        }
    }
}
