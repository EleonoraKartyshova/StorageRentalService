<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use HWI\Bundle\OAuthBundle\Controller\ConnectController;

class MyHwiOAuthController extends ConnectController
{
    /**
     * @Route("/my/hwi/o/auth", name="my_hwi_o_auth")
     */
    public function index()
    {
        return $this->render('my_hwi_o_auth/index.html.twig', [
            'controller_name' => 'MyHwiOAuthController',
        ]);
    }
}
