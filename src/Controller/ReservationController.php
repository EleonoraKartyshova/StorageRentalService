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


class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index()
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

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
        if ($formReservation->isSubmitted() && $formGoods->isSubmitted() && !($formReservation['hasDelivery']->getData())) {
            $reservation = $formReservation->getData();
            $reservation->setUserId($user);
            $goods = $formGoods->getData();
            $goods->setReservationId($reservation);
            $reservation->setGoodsId($goods);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->persist($goods);
            $entityManager->flush();
            return $this->redirectToRoute('reservations_list');
        }
        if ($formReservation->isSubmitted() && $formGoods->isSubmitted() && $formDelivery->isSubmitted() && ($formReservation['hasDelivery']->getData())) {
            $reservation = $formReservation->getData();
            $reservation->setUserId($user);
            $goods = $formGoods->getData();
            $goods->setReservationId($reservation);
            $reservation->setGoodsId($goods);
            $delivery = $formDelivery->getData();
            $delivery->setReservationId($reservation);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->persist($goods);
            $entityManager->persist($delivery);
            $entityManager->flush();
            return $this->redirectToRoute('reservations_list');
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
     * @Route("/reservation/details", name="reservation_details")
     */
    public function getReservation()
    {

    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @Route("/reservation/list", name="reservations_list")
     */
    public function getAllReservations()
    {
        return $this->render('page/my_reservations_list.html.twig', array(
            'reservation' => 'active',
        ));
    }
}
