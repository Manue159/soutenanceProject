<?php

namespace App\Controller;

use App\Entity\Employes;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function index(Request $request): Response
    {
        //debut du code
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $pole = $request->request->get('pole');
        $password = $request->request->get('password');
        $token = $this->generateToken();

        if($nom != null && $prenom != null && $email != null && $pole != null && $password != null)
        {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $employe = new Employes;

            $employe->setNom($nom);
            $employe->setPrenom($prenom);
            $employe->setEmail($email);
            $employe->setPole($pole);
            $employe->setPaswword($password_hash);
            $employe->setStatut('Disponible');
            $employe->setDateCreation(new DateTime());
            $employe->setIsDelete(false);
            $employe->setToken($token);

            if ($pole == "ADV" || $pole == "Assistant de Direction" || $pole == "Chauffeur" || $pole == "Commercial" || $pole == "Comptabilité" || $pole == "Controleur de gestion" || $pole == "Magasinier" || $pole == "Responsable Agence" || $pole == "Responsable Administratif et Financier"){
                $employe->setIsAdmin(false);
                $employe->setIsTechnicien(false);
            } 
            elseif($pole == "Datacenter et energie" || $pole == "Infrastructure Informatique et Software" ||    $pole == "Ingénieur Reseaux et Securite" || $pole == "Lift" || $pole == "Utilisateur")
            {
                $employe->setIsAdmin(false);
                $employe->setIsTechnicien(true);
            } 
            elseif($pole == "Professionnal Services Manager" || $pole == "Project Management Officer" || $pole == "Services Delivery Manager")
            {
                $employe->setIsAdmin(true);
                $employe->setIsTechnicien(true);
            }

            $this->entityManager->persist($employe);
            $this->entityManager->flush();

            $this->addFlash('success', 'Inscription réussie! Connectez-vous à présent!');
            return $this->redirectToRoute('login');

        }

        //fin du code
        return $this->render('register.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

    private function generateToken()
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
