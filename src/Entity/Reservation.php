<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

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
     * @ORM\Column(type="integer", name="storage_type_id")
     */
    private $storageTypeId;

    /**
     * @ORM\Column(type="integer", name="storage_volume_id")
     */
    private $storageVolumeId;

    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

    /**
     * @ORM\Column(type="integer", name="goods_id")
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
}
