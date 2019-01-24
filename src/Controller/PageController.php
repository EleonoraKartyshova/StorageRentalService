<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends BaseController
{
    protected $isAuth;
    protected $role;
    protected $login;

    /**
     * @Route("/", name="about_us")
     */
    public function index()
    {
        if ($this->isAuth && $this->role == "1") {
            $header = 'header/admin_header.html.twig';
        } elseif ($this->isAuth && $this->role == "0") {
            $header = 'header/auth_header.html.twig';
        } else {
            $header = 'header/not_auth_header.html.twig';
        }
        return $this->render('page/about_us.html.twig', [
            'header' => $header,
            'about_us' => 'active'
        ]);
    }

    /**
     * @Route("/page/{page}", name="page_show")
     */
    public function show($page)
    {
        if ($this->isAuth && $this->role == "1") {
            $header = 'header/admin_header.html.twig';
        } elseif ($this->isAuth && $this->role == "0") {
            $header = 'header/auth_header.html.twig';
        } else {
            $header = 'header/not_auth_header.html.twig';
        }
        return $this->render('page/'.$page.'.html.twig', [
            'header' => $header,
            $page => 'active'
        ]);
    }
}
