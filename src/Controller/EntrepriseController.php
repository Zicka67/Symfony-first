<?php

namespace App\Controller;

//A importer via clic droit sur (Entreprise::class)
use App\Entity\Entreprise;
//A importer via clic droit sur index(ManagerRegistry $doctrine)
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    // Ici on fait le lien entre la méthode et l'URL du navigateur (de la page qu'on veut afficher)
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer toutes les entreprises de la DB (une collection d'objet entreprise ici)
        $entreprises = $doctrine->getRepository(Entreprise::class)->findBy([], ["raisonSociale" => "ASC"]);

        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show()
    {
        $entreprise = "";
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}
