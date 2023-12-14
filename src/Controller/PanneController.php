<?php

namespace App\Controller;

use App\Entity\Materiels;
use App\Entity\Pannes;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanneController extends AbstractController
{
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $pannes = $doctrine->getRepository(Pannes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        return $this->render('panne.html.twig', [
            'controller_name' => 'HomeController',
            'user_connected' => $user_connected,
            'pannes' => $pannes,
        ]);
    }
    
    public function submitPanne(SessionInterface $session, Request $request, ManagerRegistry $doctrine)
    {
        $user_connected = unserialize($session->get('user_connected'));
        $type = $request->request->get('typePanne');
        $description = $request->request->get('descriptionPanne');
        $materiel = $request->request->get('matérielEnPanne');

        if($type != null && $description != null && $materiel != null)
        {
            $entityManager = $doctrine->getManager();

            $panne = new Pannes();

            $panne->setType($type);
            $panne->setDescription($description);
            $panne->setEtat("non réparée");
            $panne->setDateCreation(new DateTime());
            $panne->setIsDelete(false);
            //$panne->set

            $entityManager->persist($panne);
            $entityManager->flush();

            $this->addFlash('error', 'Votre pseudo n\'est pas enregistré!');
            return $this->redirectToRoute('panne');

        }
        $pannes = $doctrine->getRepository(Pannes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        return $this->render('add_panne.html.twig', [
            'controller_name' => 'HomeController',
            'user_connected' => $user_connected,
            'pannes' => $pannes,
            'materiels' => $materiels,
        ]);
    }
}
