<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StorageVolumeRepository")
 * @ORM\Table(name="storage_volume")
 * @ORM\HasLifecycleCallbacks
 */
class StorageVolume
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $volume;

    /**
     * @ORM\ManyToOne(targetEntity="StorageType")
     * @ORM\JoinColumn(name="storage_type_id", referencedColumnName="id")
     */
    private $storageTypeId;

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

    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function setStorageTypeId($storageTypeId)
    {
        $this->storageTypeId = $storageTypeId;
    }

    public function getStorageTypeId()
    {
        return $this->storageTypeId;
    }
}
