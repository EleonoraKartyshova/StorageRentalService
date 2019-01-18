<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User
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
    private $login;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, name="company_title")
     */
    private $companyTitle;

    /**
     * @ORM\Column(type="string", length=20, name="phone_number")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $address;

    /**
     * @ORM\Column(type="smallint", options={"default":0}, nullable=true)
     */
    private $role = 0;

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

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setCompanyTitle($companyTitle)
    {
        $this->companyTitle = $companyTitle;
    }

    public function getCompanyTitle()
    {
        return $this->companyTitle;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }
}
