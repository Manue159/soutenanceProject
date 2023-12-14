<?php

namespace App\Controller;

use App\Entity\Employes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    public function index(Request $request, SessionInterface $session, EntityManagerInterface $doctrine): Response
    {
        //debut du code
        $user_connected = unserialize($session->get('user_connected'));

        if ($user_connected != null) {
            return $this->redirectToRoute('home');
        }

        $email = $request->request->get('email');
        $password = $request->request->get('password');

        if($email != null && $password != null){
            $repository = $doctrine->getRepository(Employes::class);
            $employe = $repository->findOneBy([
                'email' => $email,
            ]);
            
            $password_hashed = ($employe != null) ? $employe->getPaswword() : "";

            if (password_verify($password, $password_hashed)) 
            {
                $session->set('user_connected', serialize($employe));

                if($employe->getIsTechnicien() == true && $employe->getIsAdmin() == true)
                {
                    return $this->redirectToRoute('panne');
                } 
                elseif($employe->getIsTechnicien() == true && $employe->getIsAdmin() == false)
                {
                    return $this->redirectToRoute('panne');
                } 
                elseif ($employe->getIsTechnicien() == false && $employe->getIsAdmin() == false)
                {
                    return $this->redirectToRoute('panne');
                }
            } else 
            {
                $this->addFlash('error', 'Mot de passe incorrect!');
            }
        }
        //fin du code

        return $this->render('login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    public function logout(SessionInterface $session, Request $request)
    {
        $session = $request->getSession();
        $session->invalidate();

        return $this->redirectToRoute('home');
    }
}
