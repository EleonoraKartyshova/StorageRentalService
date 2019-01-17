<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 * @ORM\Table(name="delivery")
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
