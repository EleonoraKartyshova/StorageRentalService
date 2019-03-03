<?php

namespace App\Controller;

use App\Entity\StorageVolume;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Goods;
use App\Entity\Delivery;
use App\Entity\Reservation;
use App\Form\GoodsType;
use App\Form\DeliveryType;
use App\Form\EditReservationType;
use App\Form\EditDeliveryType;
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
        $formReservation = $this->createForm(EditReservationType::class, $reservationForEdit);

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
            $formDelivery = $this->createForm(EditDeliveryType::class, $deliveryForEdit);
        } else {
            $deliveryForEdit = null;
            $formDelivery = $this->createForm(DeliveryType::class);
        }

        $storageVolumeForEdit = $reservationForEdit->getStorageVolumeId();

        $formReservation->handleRequest($request);
        $formGoods->handleRequest($request);
        $formDelivery->handleRequest($request);

        if ($this->checkRequiredForms($formReservation, $formGoods) && !($formReservation['hasDelivery']->getData())) {
            return $this->setReservation($formReservation, $formGoods, $storageVolumeForEdit, $deliveryForEdit);
        }

        if ($this->checkRequiredForms($formReservation, $formGoods, $formDelivery) && ($formReservation['hasDelivery']->getData())) {
            return $this->setReservation($formReservation, $formGoods, $storageVolumeForEdit, null, $formDelivery);
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

    private function setReservation($formReservation, $formGoods, $storageVolumeForEdit, $deliveryForEdit = null, $formDelivery = null)
    {
        $reservation = $formReservation->getData();

        $goods = $formGoods->getData();
        $goods->setReservationId($reservation);

        $reservation->setGoodsId($goods);

        if ($storageVolumeForEdit !== $reservation->getStorageVolumeId()) {
            $storageVolumeForEdit = $this->getDoctrine()
                ->getRepository(StorageVolume::class)
                ->findOneBy([
                    'id' => $storageVolumeForEdit,
                ]);
            $storageVolumeCountForEdit = $storageVolumeForEdit->getCount();
            $storageVolumeCountForEdit++;
            $storageVolumeForEdit->setCount($storageVolumeCountForEdit);

            $storageVolumeCount = $reservation->getStorageVolumeId()->getCount();
            $storageVolumeCount--;
            $reservation->getStorageVolumeId()->setCount($storageVolumeCount);
        }

        $entityManager = $this->getDoctrine()->getManager();
        if ($deliveryForEdit !== null) {
            $entityManager->remove($deliveryForEdit);
        }
        $entityManager->persist($reservation);
        $entityManager->persist($goods);
        if ($formDelivery !== null) {
            $delivery = $formDelivery->getData();
            $delivery->setReservationId($reservation);
            $entityManager->persist($delivery);
        }
        $entityManager->flush();

        $this->addFlash('success', 'Saved!');

        return $this->redirectToRoute('admin_edit_reservation', ['id' => $reservation->getId()]);
    }
}
