<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoodsRepository")
 * @ORM\Table(name="goods")
 * @ORM\HasLifecycleCallbacks
 */
class Goods
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="Reservation", cascade={"persist", "remove"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="GoodsProperty")
     * @ORM\JoinColumn(name="goods_property_id", referencedColumnName="id")
     */
    private $goodsPropertyId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @ORM\OneToOne(targetEntity="Reservation")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id", onDelete="CASCADE")
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

    public function setGoodsPropertyId($goodsPropertyId)
    {
        $this->goodsPropertyId = $goodsPropertyId;
    }

    public function getGoodsPropertyId()
    {
        return $this->goodsPropertyId;
    }

    public function setDetails($details)
    {
        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
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
