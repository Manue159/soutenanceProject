<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('forgot_password.html.twig', [
            'controller_name' => 'ForgotPasswordController',
        ]);
    }
}
