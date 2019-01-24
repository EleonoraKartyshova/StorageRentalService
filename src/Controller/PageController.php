<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends FrontController
{
    protected static $isAuth;
    protected static $role;
    protected static $login;
    protected static $header;
    protected static $footer;
    /**
     * @Route("/", name="about_us")
     */
    public function index()
    {
        return $this->render('page/about_us.html.twig', [
            'header' => parent::$header,
            'about_us' => 'active',
            'footer' => parent::$footer,
            'user_login' => parent::$login
        ]);
    }

    /**
     * @Route("/page/{page}", name="page_show")
     */
    public function show($page)
    {
        return $this->render('page/'.$page.'.html.twig', [
            'header' => parent::$header,
            $page => 'active',
            'footer' => parent::$footer,
            'user_login' => parent::$login
        ]);
    }
}
