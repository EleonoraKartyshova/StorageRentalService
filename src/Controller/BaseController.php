<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;

class BaseController extends AbstractController
{
    protected $isAuth = false;
    protected $role = "";
    protected $login = "";

    public function __construct()
    {
        if ($this->isAuth) {
            $user = new User();
            $this->role = $user->getRole();
            $this->login = $user->getLogin();
        }
    }
}
