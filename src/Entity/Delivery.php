<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 * @ORM\Table(name="delivery")
 * @ORM\HasLifecycleCallbacks
 */
class Delivery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", name="date_from")
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="date", name="date_to")
     */
    private $dateTo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=20, name="phone_number")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="integer", name="reservation_id")
     */
    private $reservationId;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(type="datetime", name="updated_at", nullable = true)
     */
    private $updatedAt;

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new DateTime("now");
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = new Datetime($dateFrom);
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateTo($dateTo)
    {
        $this->dateTo = new Datetime($dateTo);
    }

    public function getDateTo()
    {
        return $this->dateTo;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setReservationId($reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function getReservationId()
    {
        return $this->reservationId;
    }
}
