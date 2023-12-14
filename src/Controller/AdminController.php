<?php

namespace App\Controller;

use DateTime;
use App\Entity\Pannes;
use App\Entity\Employes;
use App\Entity\Materiels;
use App\Entity\EmployesPannes;
use App\Entity\TypesMateriels;
use Doctrine\DBAL\Types\Types;
use App\Entity\EmplacementsMateriels;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        return $this->render('admin/home.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function adminShowEmploye(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $employes = $doctrine->getRepository(Employes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        return $this->render('admin/employe.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'employes' => $employes,
        ]);
    }

    public function adminAddEmploye(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $employes = $doctrine->getRepository(Employes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $pole = $request->request->get('pole');
        $token = $this->generateToken();

        if ($nom != null && $prenom != null && $email != null && $pole != null) {
            $entityManager = $doctrine->getManager();

            $is_new_email = ($doctrine->getRepository(Employes::class)->findOneBy(['email' => $email]) != null) ? false : true;
            
            if($is_new_email == true){
                $employe = new Employes();

                $employe->setNom($nom);
                $employe->setPrenom($prenom);
                $employe->setEmail($email);
                $employe->setPaswword("");
                $employe->setPole($pole);
                $employe->setStatut("Disponible");
                $employe->setDateCreation(new DateTime());
                $employe->setIsDelete(false);
                $employe->setToken($token);

                if ($pole == "ADV" || $pole == "Assistant de Direction" || $pole == "Chauffeur" || $pole == "Commercial" || $pole == "Comptabilité" || $pole == "Controleur de gestion" || $pole == "Magasinier" || $pole == "Responsable Agence" || $pole == "Responsable Administratif et Financier") {
                    $employe->setIsAdmin(false);
                    $employe->setIsTechnicien(false);
                } elseif ($pole == "Datacenter et energie" || $pole == "Infrastructure Informatique et Software" ||    $pole == "Ingénieur Reseaux et Securite" || $pole == "Lift" || $pole == "Utilisateur") {
                    $employe->setIsAdmin(false);
                    $employe->setIsTechnicien(true);
                } elseif ($pole == "Professionnal Services Manager" || $pole == "Project Management Officer" || $pole == "Services Delivery Manager") {
                    $employe->setIsAdmin(true);
                    $employe->setIsTechnicien(true);
                }

                $entityManager->persist($employe);
                $entityManager->flush();

                $this->addFlash('success', 'Ajout d\'un employé effectué avec succes');
                return $this->redirectToRoute('admin-show-employe');
            } else{
                $this->addFlash('error', 'Cette adresse email est déjà utilisée.');
                return $this->redirectToRoute('admin-show-employe');
            }
        }

        return $this->render('admin/employe.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'employes' => $employes,
        ]);
    }

    public function adminUpdateEmploye(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $employes = $doctrine->getRepository(Employes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $id = $request->request->get('id');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $pole = $request->request->get('pole');
        $statut = $request->request->get('statut');

        if ($nom != null && $prenom != null && $email != null && $pole != null && $statut != null) {
            $entityManager = $doctrine->getManager();

            $employe = $doctrine->getRepository(Employes::class)->findOneBy(['is_delete' => false, 'id' => $id]);

            if ($employe != null) 
            {
                $employe->setNom($nom);
                $employe->setPrenom($prenom);
                $employe->setEmail($email);
                $employe->setPole($pole);
                $employe->setStatut($statut);

                if ($pole == "ADV" || $pole == "Assistant de Direction" || $pole == "Chauffeur" || $pole == "Commercial" || $pole == "Comptabilité" || $pole == "Controleur de gestion" || $pole == "Magasinier" || $pole == "Responsable Agence" || $pole == "Responsable Administratif et Financier") {
                    $employe->setIsAdmin(false);
                    $employe->setIsTechnicien(false);
                } elseif ($pole == "Datacenter et energie" || $pole == "Infrastructure Informatique et Software" ||    $pole == "Ingenieur Reseaux et Securite" || $pole == "Lift" || $pole == "Utilisateur") {
                    $employe->setIsAdmin(false);
                    $employe->setIsTechnicien(true);
                } elseif ($pole == "Professionnal Services Manager" || $pole == "Project Management Officer" || $pole == "Services Delivery Manager") {
                    $employe->setIsAdmin(true);
                    $employe->setIsTechnicien(true);
                }

                $entityManager->flush();

                $this->addFlash('success', 'Modification des informations de l\'employé effectuée avec succes.');
                return $this->redirectToRoute('admin-show-employe');
            }
        }

        return $this->render('admin/employe.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'employes' => $employes,
        ]);
    }

    public function adminDeleteEmploye(SessionInterface $session, ManagerRegistry $doctrine, Request $request){
        $user_connected = unserialize($session->get('user_connected'));

        $id = $request->request->get('id');

        $employe_to_delete = $doctrine->getRepository(Employes::class)->findOneBy(['is_delete' => false,'id' => $id]);

        if($employe_to_delete != null)
        {
            $entityManager = $doctrine->getManager();

            $employe_to_delete->setIsDelete(true);

            $entityManager->flush();

            $this->addFlash('success', 'L\'employé a été supprimé avec succes.');
            return $this->redirectToRoute('admin-show-employe');
        }

        return $this->render('admin/employe.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
        ]);
    }

    public function adminShowMateriel(SessionInterface $session, ManagerRegistry $doctrine): Response
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

        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materielsList' => $materielsList,
            'typesMateriels' => $typesMateriels,
            'emplacementsMateriels' => $emplacementsMateriels,
        ]);
    }

    public function adminAddMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $numero_serie = $request->request->get('numero_serie');
        $type_materiel = $request->request->get('type_materiel');
        $emplacement_materiel = $request->request->get('emplacement_materiel');

        if($numero_serie != null && $emplacement_materiel != null && $type_materiel != null)
        {
            $is_new_numero_serie = ($doctrine->getRepository(Materiels::class)->findOneBy(['numero_serie' => $numero_serie]) != null) ? false : true;

            if($is_new_numero_serie == true){
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
            } else{
                $this->addFlash('error', 'Le numero de serie est déjà enregistré.');
                return $this->redirectToRoute('admin-show-materiel');
            }
        }

        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function adminUpdateMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false, 'id' => 'DESC']);

        $numero_serie = $request->request->get('numero_serie');
        $type_materiel = $request->request->get('type_materiel');
        $emplacement_materiel = $request->request->get('emplacement_materiel');

        if($numero_serie !=null && $emplacement_materiel != null && $type_materiel != null)
        {
            $entityManager = $doctrine->getManager();

            $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false], ['numero_serie' => $numero_serie]);

            $type_materiel = $doctrine->getRepository(TypesMateriels::class)->findOneBy(['libelle' => $type_materiel, 'is_delete' => false]);

            $emplacement_materiel = $doctrine->getRepository(EmplacementsMateriels::class)->findOneBy(['libelle' => $emplacement_materiel, 'is_delete' => false]);

            if($materiel != null){
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

        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function adminDeleteMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $id = $request->request->get('id');

        if($id != null)
        {
            $entityManager = $doctrine->getManager();

            $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false, 'id' => $id]);

            if($materiel != null){
                $materiel->setIsDelete(true);

                $entityManager->flush();

                $this->addFlash('success', 'Le matériel a été supprimé avec succes!');
                return $this->redirectToRoute('admin-show-materiel');
            }
        }

        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function adminAddTypeMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request){
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $libelle = $request->request->get('libelleType');

        if($libelle != null){
            $entityManager = $doctrine->getManager();

            $type = new TypesMateriels();

            $type->setLibelle($libelle);
            $type->setDateCreation(new DateTime());
            $type->setIsDelete(false);

            $entityManager->persist($type);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout du type de matériel effectuée avec succes!');
            return $this->redirectToRoute('admin-show-materiel');
        }
        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function adminAddEmplacementMateriel(SessionInterface $session, ManagerRegistry $doctrine, Request $request){
        $user_connected = unserialize($session->get('user_connected'));
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $libelle = $request->request->get('libelleEmplacement');

        if ($libelle != null) {
            $entityManager = $doctrine->getManager();

            $emplacement = new EmplacementsMateriels();

            $emplacement->setLibelle($libelle);
            $emplacement->setDateCreation(new DateTime());
            $emplacement->setIsDelete(false);

            $entityManager->persist($emplacement);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout du nouvel emplacement effectué avec succes!');
            return $this->redirectToRoute('admin-show-materiel');
        }
        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'materiels' => $materiels,
        ]);
    }

    public function adminShowPanne(ManagerRegistry $doctrine, SessionInterface $session, Request $request): Response
    {
        //dd('hello!');
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

        $numero_serie = $request->request->get('materiel');
        $type = $request->request->get('type_panne');
        $description = $request->request->get('description');
        $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false, 'numero_serie' => $numero_serie]);

        if ($type != null && $description  != null && $materiel != null) {
            $entityManager = $doctrine->getManager();

            $panne = new Pannes();

            $panne->setMateriel($materiel);
            $panne->setType($type);
            $panne->setDescription($description);
            $panne->setEtat("non réparée");
            $panne->setDateCreation(new DateTime());
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
            
            //return $this->redirectToRoute('admin-show-panne');
        }
        return $this->render('admin/panne.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'pannesList' => $pannesList,
            'materiels' => $materiels
        ]);
    }

    public function adminAddPanne(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));

        $numero_serie = $request->request->get('materiel');
        $type = $request->request->get('type_panne');
        $description = $request->request->get('description');
        $materiels = $doctrine->getRepository(Materiels::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false, 'numero_serie' => $numero_serie]);

        $panneList = [];

        if ($type != null && $description  != null && $materiel != null) {
            $entityManager = $doctrine->getManager();
       
            $panne = new Pannes();

            $panne->setMateriel($materiel);
            $panne->setType($type);
            $panne->setDescription($description);
            $panne->setEtat("non réparée");
            $panne->setDateCreation(new DateTime());
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
            return $this->redirectToRoute('admin-show-panne');
        }

        return $this->render('admin/panne.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            // 'pannes' => $pannes,
            'pannesList' => $panneList,
            'materiels' => $materiels
        ]);
    }

    public function adminUpdatePanne(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));
        $pannes = $doctrine->getRepository(Pannes::class)->findBy(['is_delete' => false], ['id' => 'DESC']);

        $id = $request->request->get('id');
        $numero_serie = $request->request->get('numero_serie');
        $type = $request->request->get('typePanne');
        $etat = $request->request->get('etatPanne');
        $description = $request->request->get('descriptionPanne');

        $materiel = $doctrine->getRepository(Materiels::class)->findOneBy(['is_delete' => false, 'numero_serie' => $numero_serie]);

        if ($type != null && $description  !== null && $materiel != null) {
            $entityManager = $doctrine->getManager();

            $panne = new Pannes();

            $panne->setMateriel($materiel);
            $panne->setType($type);
            $panne->setDescription($description);
            $panne->setEtat($etat);

            $this->addFlash('success', 'Modification de la panne effectué avec succes');
            return $this->redirectToRoute('admin-show-panne');
        }

        return $this->render('admin/panne.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
            'pannes' => $pannes,
        ]);
    }

    public function adminDeletePanne(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));

        $id = $request->request->get('id');

        if ($id != null) {
            $entityManager = $doctrine->getManager();

            $panne = $doctrine->getRepository(Pannes::class)->findOneBy(['is_delete' => false, 'id' => $id]);

            if ($panne != null) {
                $panne->setIsDelete(true);

                $entityManager->flush();

                $this->addFlash('success', 'Le matériel a été supprimé avec succes!');
                return $this->redirectToRoute('admin-show-materiel');
            }
        }

        return $this->render('admin/materiel.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
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

    public function adminAddFaq(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $user_connected = unserialize($session->get('user_connected'));

        return $this->render('admin/faq.html.twig', [
            'controller_name' => 'AdminController',
            'user_connected' => $user_connected,
        ]);
    }

}
