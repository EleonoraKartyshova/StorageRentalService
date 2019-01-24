<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;

class FrontController extends AbstractController
{
    protected static $isAuth = false;
    protected static $role = "";
    protected static $login = "";
    protected static $header = "";
    protected static $footer = "";

    public function __construct()
    {
//        if (self::$isAuth) {
//            $user = new User();
//            self::$role = $user->getRole();
//            self::$login = $user->getLogin();
//        }

        if (self::$isAuth && self::$role == "1") {
            self::$header = 'header/admin_header.html.twig';
            self::$footer = 'footer/auth_footer.html.twig';
        } elseif (self::$isAuth && self::$role == "0") {
            self::$header = 'header/auth_header.html.twig';
            self::$footer = 'footer/auth_footer.html.twig';
        } else {
            self::$header = 'header/not_auth_header.html.twig';
            self::$footer = 'footer/not_auth_footer.html.twig';
        }
    }
}
