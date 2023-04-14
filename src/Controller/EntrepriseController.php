<?php

namespace App\Controller;

//A importer via clic droit sur (Entreprise::class)
use App\Entity\Entreprise;
//A importer via clic droit sur (EntrepriseType::class)
use App\Form\EntrepriseType;
//A importer via clic droit sur index(ManagerRegistry $doctrine)
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
  
    //Route entre le lien de la méthode et l'URL (qu'on veut afficher)
    #[Route('/entreprise/add', name: 'add_entreprise')]
    //route pour editer a partir de la function add (bien penser a mettre l'id pour qu'il sache quel entreprise ou veut editer)
    #[Route('/entreprise/{id}edit', name: 'edit_entreprise')]
    // Ici on créer une function pour add une entreprise 
    // en paramètre : 
    // D'ABORD on ajoute ManagerRegistery $doctrine pour se connecter à la DB
    // PUIS l'objet qu'on souhaite ajouter ici Entreprise $entreprise, null pour lui donner une valeur par defaut en DB
    // ENFIN Request
    public function add(ManagerRegistry $doctrine, Entreprise $entreprise = null, Request $request): Response {
        //Condition pour faire passer la function ADD a EDIT, si l'entreprise n'existe pas on ADD sinon on EDIT
        if(!$entreprise) {
            $entreprise = new Entreprise();
        }
        //On va construire un form avec $builder qui est dans EntrepriseType( form ), de l'entity entreprise
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        //Ici handleRequest() va analyser les données pour les insérer dans le form
        $form->handleRequest($request);

        //SI le formulaire est envoyé ET passe les filter
        if($form->isSubmitted() && $form->isValid() ) {
            //On créer un objet entreprise et on lui donne (hydrate) les data du form (qu'on a dans form et entrepriseType)
            $entreprise = $form->getData();
            //On récupère le manager de $doctrine pour lui faire faire la préparation et l'execution(persist et flush sont natif du manager)
            $entityManager = $doctrine->getManager();
            //On PREPARE
            $entityManager->persist($entreprise);
            //On EXECUTE
            $entityManager->flush();

            //Enfin on redirige vers la vue app_entreprise
            return $this->redirectToRoute('app_entreprise');
        }

        //Vue pour afficher le formulaire d'ajout
        return $this->render('entreprise/add.html.twig', [
            //'leNomQuonVeut' et on lui donne une vue générée par createView du form
           'formAddEntreprise' => $form->createView()
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(ManagerRegistry $doctrine, Entreprise $entreprise): Response
    {   
        //On récupère le manager de $doctrine pour lui faire faire la préparation et l'execution(remove et flush sont natif du manager)
        $entityManager = $doctrine->getManager();
        //On enlève l'élément de la collection
        $entityManager->remove($entreprise);
        //On execute
        $entityManager->flush();

        //On redirige après la suppression 
        return $this->redirectToRoute('app_entreprise');
    }

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
    
}
