<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ORM\Table(name="reservation")
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }
}
