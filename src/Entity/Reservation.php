<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ORM\Table(name="reservation")
 * @ORM\HasLifecycleCallbacks
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="Goods", cascade={"persist", "remove"})
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
     * @ORM\ManyToOne(targetEntity="StorageType")
     * @ORM\JoinColumn(name="storage_type_id", referencedColumnName="id")
     */
    private $storageTypeId;

    /**
     * @ORM\ManyToOne(targetEntity="StorageVolume")
     * @ORM\JoinColumn(name="storage_volume_id", referencedColumnName="id")
     */
    private $storageVolumeId;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @ORM\OneToOne(targetEntity="Goods")
     * @ORM\JoinColumn(name="goods_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $goodsId;

    /**
     * @ORM\Column(type="boolean", name="has_delivery", options={"default":0}, nullable=true)
     */
    private $hasDelivery = 1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

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
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDateFrom($dateFrom)
    {
//        $this->dateFrom = new Datetime($dateFrom);
        $this->dateFrom = $dateFrom;
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateTo($dateTo)
    {
//        $this->dateTo = new Datetime($dateTo);
        $this->dateTo = $dateTo;
    }

    public function getDateTo()
    {
        return $this->dateTo;
    }

    public function setStorageTypeId($storageTypeId)
    {
        $this->storageTypeId = $storageTypeId;
    }

    public function getStorageTypeId()
    {
        return $this->storageTypeId;
    }

    public function setStorageVolumeId($storageVolumeId)
    {
        $this->storageVolumeId = $storageVolumeId;
    }

    public function getStorageVolumeId()
    {
        return $this->storageVolumeId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setGoodsId($goodsId)
    {
        $this->goodsId = $goodsId;
    }

    public function getGoodsId()
    {
        return $this->goodsId;
    }

    public function setHasDelivery($hasDelivery)
    {
        $this->hasDelivery = $hasDelivery;
    }

    public function getHasDelivery()
    {
        return $this->hasDelivery;
    }

    public function setDetails($details)
    {
        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
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
