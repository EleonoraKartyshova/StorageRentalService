<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Entity\Delivery;
use App\Entity\Reservation;
use App\Form\GoodsType;
use App\Form\DeliveryType;
use App\Form\ReservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReservationController extends AbstractController
{
    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @Route("/reservation/create", name="create_reservation")
     */
    public function createReservation(Request $request, Security $security)
    {
        $formReservation = $this->createForm(ReservationType::class);
        $formGoods = $this->createForm(GoodsType::class);
        $formDelivery = $this->createForm(DeliveryType::class);

        $user = $security->getUser();

        $formReservation->handleRequest($request);
        $formGoods->handleRequest($request);
        $formDelivery->handleRequest($request);

        if ($this->checkRequiredForms($formReservation, $formGoods) && !($formReservation['hasDelivery']->getData())) {
            return $this->setReservation($user, $formReservation, $formGoods);
        }
        if ($this->checkRequiredForms($formReservation, $formGoods, $formDelivery) && ($formReservation['hasDelivery']->getData())) {
            return $this->setReservation($user, $formReservation, $formGoods, $formDelivery);
        }
        return $this->render('page/create_reservation.html.twig', array(
            'reservation' => 'active',
            'reservation_form' => $formReservation->createView(),
            'goods_form' => $formGoods->createView(),
            'delivery_form' => $formDelivery->createView()
        ));
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @Route("/reservation_details/{id}", name="reservation_details", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function getReservation($id, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getId();

        $reservation = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findOneBy([
                'id' => $id,
                'userId' => $userId,
            ]);

        if ($reservation->getHasDelivery()) {
            $delivery = $this->getDoctrine()
                ->getRepository(Delivery::class)
                ->findOneBy([
                    'reservationId' => $id,
                ]);

            return $this->render('page/reservation_details.html.twig', [
                'reserve' => 'active',
                'reservation' => $reservation,
                'delivery' => $delivery,
            ]);
        } else {
            return $this->render('page/reservation_details.html.twig', [
                'reserve' => 'active',
                'reservation' => $reservation,
            ]);
        }
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @Route("/reservation/list", name="reservations_list")
     */
    public function getAllReservations(Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getId();

        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findBy([
                'userId' => $userId,
            ]);

        return $this->render('page/my_reservations_list.html.twig', [
            'reserve' => 'active',
            'reservations' => $reservations
        ]);
    }

    private function checkRequiredForms($formReservation, $formGoods, $formDelivery = null)
    {
        if ($formDelivery == null) {
            return $formReservation->isSubmitted() &&
                $formGoods->isSubmitted() &&
                $formReservation->isValid() &&
                $formGoods->isValid();
        } else {
            return $formReservation->isSubmitted() &&
                $formGoods->isSubmitted() &&
                $formDelivery->isSubmitted() &&
                $formReservation->isValid() &&
                $formGoods->isValid() &&
                $formDelivery->isValid();
        }
    }

    private function setReservation($user, $formReservation, $formGoods, $formDelivery = null)
    {
        $reservation = $formReservation->getData();
        $reservation->setUserId($user);

        $goods = $formGoods->getData();
        $goods->setReservationId($reservation);

        $reservation->setGoodsId($goods);

        $storageVolumeCount = $reservation->getStorageVolumeId()->getCount();
        $storageVolumeCount--;
        $reservation->getStorageVolumeId()->setCount($storageVolumeCount);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $entityManager->persist($goods);
        if ($formDelivery !== null) {
            $delivery = $formDelivery->getData();
            $delivery->setReservationId($reservation);
            $entityManager->persist($delivery);
        }
        $entityManager->flush();

        $this->addFlash('success', 'Saved!');

        return $this->redirectToRoute('reservations_list');
    }
}
