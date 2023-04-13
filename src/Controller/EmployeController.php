<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    // Ici on fait le lien entre la méthode et l'URL du navigateur (de la page qu'on veut afficher)
    #[Route('/employe', name: 'app_employe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer toutes les entreprises de la DB (une collection d'objet entreprise ici) en les classants par ordre alphabétique via 
        // @method Employe[]  findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) qui est une méthode de base dans Repository
        // ICI $doctrine->getRepository(Employe::class)->findBy(["ville" => "STRASBOURG"], ["nom" => "ASC"]); = SELECT *, FROM employe, WHERE ville = STRASBOURG, ORDER BY ASC
        $employes = $doctrine->getRepository(Employe::class)->findBy(["ville" => "STRASBOURG"], ["nom" => "ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }

    // :id ici = {id}
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
        ]);
    }
}
