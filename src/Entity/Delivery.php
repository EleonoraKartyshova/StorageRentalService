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
     * @ORM\Column(type="date", name="date_from", nullable = true)
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="date", name="date_to", nullable = true)
     */
    private $dateTo;

    /**
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=20, name="phone_number", nullable = true)
     */
    private $phoneNumber;

    /**
     * @ORM\OneToOne(targetEntity="Reservation")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id", onDelete="CASCADE", nullable = true)
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
        $this->dateFrom = $dateFrom;
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
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

    public function setReservationId(?Reservation $reservationId): self
    {
        $this->reservationId = $reservationId;
        return $this;
    }

    public function getReservationId()
    {
        return $this->reservationId;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
