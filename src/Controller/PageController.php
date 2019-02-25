<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="about_us")
     */
    public function index()
    {
        return $this->render('page/about_us.html.twig', [
            'about_us' => 'active',
        ]);
    }

    /**
     * @Route("/page/{page}", name="page_show")
     */
    public function show($page)
    {
        return $this->render('page/'.$page.'.html.twig', [
            $page => 'active',
        ]);
    }
}
