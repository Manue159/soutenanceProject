<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(SessionInterface $session): Response
    {
        $user_connected = unserialize($session->get('user_connected'));

        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
            'user_connected' => $user_connected,
        ]);
    }
}
