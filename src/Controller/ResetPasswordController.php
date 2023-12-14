<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('reset_password.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
