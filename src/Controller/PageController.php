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
        return $this->render('page/about_us.html.twig', [
            'header' => 'header/not_auth_header.html.twig',
            'about_us' => 'active'
        ]);
    }

    /**
     * @Route("/page/{page}", name="page_show")
     */
    public function show($page)
    {
        return $this->render('page/'.$page.'.html.twig', [
            'header' => 'header/not_auth_header.html.twig',
            $page => 'active'
        ]);
    }
}
