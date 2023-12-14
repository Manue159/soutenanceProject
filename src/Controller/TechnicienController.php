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

class TechnicienController extends AbstractController
{
    public function index(SessionInterface $session): Response
    {
        $user_connected = unserialize($session->get('user_connected'));

        return $this->render('technicien/index.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
        ]);
    }

    public function technicienShowPanne(SessionInterface $session, ManagerRegistry $doctrine): Response
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

        return $this->render('technicien/panne.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            'pannesList' => $pannesList,
            'materiels' => $materiels
        ]);
    }

    public function technicienUpdatePanne(SessionInterface $session, ManagerRegistry $doctrine): Response
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

        return $this->render('technicien/panne.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            'pannesList' => $pannesList,
            'materiels' => $materiels
        ]);
    }

    public function technicienAddPanne(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
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

        $employe = $user_connected;
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

            /* $employePanne = new EmployesPannes();

            $employePanne->setEmployes($user_connected);
            $employePanne->setPannes($panne);
            $employePanne->setDateCreation(new DateTime());
            $employePanne->setIsDelete(false);

            $entityManager->persist($employePanne);
            $entityManager > flush(); */

            $this->addFlash('success', 'Ajout d\'une panne effectué avec succes');
            return $this->redirectToRoute('admin-show-panne');
        }

        return $this->render('technicien/panne.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            // 'pannes' => $pannes,
            // 'pannesList' => $pannesList,
            // 'materiels' => $materiels
        ]);
    }

    public function technicienShowMateriel(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);
        $typesMateriels = $doctrine->getRepository(TypesMateriels::class)->findBy(['is_delete' => false], ['libelle' => 'ASC']);
        $emplacementsMateriels = $doctrine->getRepository(EmplacementsMateriels::class)->findBy(['is_delete' => false], ['libelle' => 'ASC']);

        $materielsList = [];
        foreach ($materiels as $key => $value) {
            $matObjet = [];
            $matObjet["materiel"] = $value;
            $matObjet["type"] = $value->getType()->getLibelle();
            $matObjet["emplacement"] = $value->getEmplacement()->getLibelle();
            $materielsList[] = $matObjet;
        }

        return $this->render('technicien/materiel.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            'materielsList' => $materielsList,
            'typesMateriels' => $typesMateriels,
            'emplacementsMateriels' => $emplacementsMateriels,
        ]);
    }

    public function technicienAddMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $numero_serie = $request->request->get('numero_serie');
        $type_materiel = $request->request->get('type_materiel');
        $emplacement_materiel = $request->request->get('emplacement_materiel');

        if ($numero_serie != null && $emplacement_materiel != null && $type_materiel != null) {
            $is_new_numero_serie = ($doctrine->getRepository(Materiels::class)->findOneBy(['numero_serie' => $numero_serie]) != null) ? false : true;

            if ($is_new_numero_serie == true) {
                $entityManager = $doctrine->getManager();

                $materiel = new Materiels();

                $type_materiel = $doctrine->getRepository(TypesMateriels::class)->findOneBy(['libelle' => $type_materiel, 'is_delete' => false]);

                $emplacement_materiel = $doctrine->getRepository(EmplacementsMateriels::class)->findOneBy(['libelle' => $emplacement_materiel, 'is_delete' => false]);

                $materiel->setNumeroSerie($numero_serie);
                $materiel->setType($type_materiel);
                $materiel->setEmplacement($emplacement_materiel);
                $materiel->setDateCreation(new DateTime());
                $materiel->setIsDelete(false);

                $entityManager->persist($materiel);
                $entityManager->flush();

                $this->addFlash('success', 'Ajout d\'un matériel effectué avec succes');
                return $this->redirectToRoute('admin-show-materiel');
            } else {
                $this->addFlash('error', 'Le numero de serie est déjà enregistré.');
                return $this->redirectToRoute('admin-show-materiel');
            }
        }

        return $this->render('technicien/materiel.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function technicienUpdateMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false, 'id' => 'DESC']);

        $numero_serie = $request->request->get('numero_serie');
        $type_materiel = $request->request->get('type_materiel');
        $emplacement_materiel = $request->request->get('emplacement_materiel');

        if ($numero_serie != null && $emplacement_materiel != null && $type_materiel != null) {
            $entityManager = $doctrine->getManager();

            $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false], ['numero_serie' => $numero_serie]);

            $type_materiel = $doctrine->getRepository(TypesMateriels::class)->findOneBy(['libelle' => $type_materiel, 'is_delete' => false]);

            $emplacement_materiel = $doctrine->getRepository(EmplacementsMateriels::class)->findOneBy(['libelle' => $emplacement_materiel, 'is_delete' => false]);

            if ($materiel != null) {
                $materiel->setNumeroSerie($numero_serie);
                $materiel->setType($type_materiel);
                $materiel->setEmplacement($emplacement_materiel);
                $materiel->setDateCreation(new DateTime());
                $materiel->setIsDelete(false);

                $entityManager->flush();

                $this->addFlash('success', 'Modification des informations du matériel effectuée avec succes!');
                return $this->redirectToRoute('admin-show-materiel');
            }
        }

        return $this->render('technicien/materiel.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function technicienDeleteMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $id = $request->request->get('id');

        if ($id != null) {
            $entityManager = $doctrine->getManager();

            $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false, 'id' => $id]);

            if ($materiel != null) {
                $materiel->setIsDelete(true);

                $entityManager->flush();

                $this->addFlash('success', 'Le matériel a été supprimé avec succes!');
                return $this->redirectToRoute('admin-show-materiel');
            }
        }

        return $this->render('technicien/materiel.html.twig', [
            'controller_name' => 'TechnicienController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }
}
