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

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/edit_reservation/{id}", name="admin_edit_reservation", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function editReservation($id, Request $request)
    {
        $reservationForEdit = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findOneBy([
                'id' => $id,
            ]);
        $formReservation = $this->createForm(ReservationType::class, $reservationForEdit);

        $goodsForEdit = $this->getDoctrine()
            ->getRepository(Goods::class)
            ->findOneBy([
                'id' => $reservationForEdit->getGoodsId(),
            ]);
        $formGoods = $this->createForm(GoodsType::class, $goodsForEdit);

        if ($reservationForEdit->getHasDelivery() == '1') {
            $deliveryForEdit = $this->getDoctrine()
                ->getRepository(Delivery::class)
                ->findOneBy([
                    'reservationId' => $reservationForEdit->getId(),
                ]);
            $formDelivery = $this->createForm(DeliveryType::class, $deliveryForEdit);
        } else {
            $formDelivery = $this->createForm(DeliveryType::class);
        }

        $formReservation->handleRequest($request);
        $formGoods->handleRequest($request);
        $formDelivery->handleRequest($request);

        if ($this->checkRequiredForms($formReservation, $formGoods) && !($formReservation['hasDelivery']->getData())) {
            $reservation = $formReservation->getData();

            $goods = $formGoods->getData();
            $goods->setReservationId($reservation);

            $reservation->setGoodsId($goods);

            $entityManager = $this->getDoctrine()->getManager();

            if (isset($deliveryForEdit)) {
                $entityManager->remove($deliveryForEdit);
            }
            $entityManager->persist($reservation);
            $entityManager->persist($goods);
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_edit_reservation', ['id' => $id]);
        }

        if ($this->checkRequiredForms($formReservation, $formGoods, $formDelivery) && ($formReservation['hasDelivery']->getData())) {
            $reservation = $formReservation->getData();

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

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_edit_reservation', ['id' => $id]);
        }

        return $this->render('page/admin_edit_reservation.html.twig', [
            'admin' => 'active',
            'edit_reservation_form' => $formReservation->createView(),
            'edit_goods_form' => $formGoods->createView(),
            'edit_delivery_form' => $formDelivery->createView(),
            'reservation' => $reservationForEdit,
        ]);
    }

    private function checkRequiredForms($formReservation, $formGoods, $formDelivery = null)
    {
        if ($formDelivery == null) {
            return $formReservation->isSubmitted() &&
                $formGoods->isSubmitted();
//                $formReservation->isValid() &&
//                $formGoods->isValid();
        } else {
            return $formReservation->isSubmitted() &&
                $formGoods->isSubmitted() &&
                $formDelivery->isSubmitted();
//                $formReservation->isValid() &&
//                $formGoods->isValid() &&
//                $formDelivery->isValid();
        }
    }
}
