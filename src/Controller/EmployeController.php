<?php

namespace App\Controller;

use DateTime;
use App\Entity\Pannes;
use App\Entity\Materiels;
use App\Entity\EmployesPannes;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    public function index(SessionInterface $session): Response
    {
        $user_connected = unserialize($session->get('user_connected'));

        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'user_connected' => $user_connected,
        ]);
    }

    public function employeShowPanne(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);
        $pannes = $doctrine->getRepository(EmployesPannes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $pannesList = [];
        foreach ($pannes as $key => $value) {
            $panneObjet = [];
            $panneObjet["panne"] = $value->getPannes();
            $panneObjet["prenomEmploye"] = $value->getEmployes()->getPrenom();
            $panneObjet["nomEmploye"] = $value->getEmployes()->getNom();
            $pannesList[] = $panneObjet;
        }

        return $this->render('admin/panne.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'pannesList' => $pannesList,
            'materiels' => $materiels
        ]);
    }

    public function employeAddPanne(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        /* $pannes = $doctrine->getRepository(Pannes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);
        $pannesList = [];
        foreach ($pannes as $key => $value) {
            $panneObjet = [];
            $panneObjet["panne"] = $value->getPannes();
            $panneObjet["prenomEmploye"] = $value->getEmployes()->getPrenom();
            $panneObjet["nomEmploye"] = $value->getEmployes()->getNom();
            $pannesList[] = $panneObjet;
        }
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);
        */

        $numero_serie = $request->request->get('materiel');
        $type = $request->request->get('type_panne');
        $description = $request->request->get('description');

        $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false, 'numero_serie' => $numero_serie]);

        //$employe = $user_connected;
        if ($type != null && $description  !== null && $materiel != null) {
            $entityManager = $doctrine->getManager();

            $panne = new Pannes();

            $panne->setMateriel($materiel);
            $panne->setType($type);
            $panne->setDescription($description);
            $panne->setEtat("non réparée");
            $panne->setDateCreation(new  DateTime());
            $panne->setIsDelete(false);

            $entityManager->persist($panne);
            $entityManager > flush();

            $employePanne = new EmployesPannes();

            $employePanne->setEmployes($user_connected);
            $employePanne->setPannes($panne);
            $employePanne->setDateCreation(new DateTime());
            $employePanne->setIsDelete(false);

            $entityManager->persist($employePanne);
            $entityManager > flush(); 

            $this->addFlash('success', 'Ajout d\'une panne effectué avec succes');
            return $this->redirectToRoute('employe-show-panne');
        }

        return $this->render('admin/panne.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            // 'pannes' => $pannes,
            // 'pannesList' => $pannesList,
            // 'materiels' => $materiels
        ]);
    }
}
