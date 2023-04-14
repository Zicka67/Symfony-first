<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    // Ici on fait le lien entre la méthode et l'URL du navigateur (de la page qu'on veut afficher)
    #[Route('/employe', name: 'app_employe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer toutes les employes de la DB (une collection d'objet employe ici) en les classants par ordre alphabétique via 
        // @method Employe[]  findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) qui est une méthode de base dans Repository
        // ICI $doctrine->getRepository(Employe::class)->findBy(["ville" => "STRASBOURG"], ["nom" => "ASC"]); = SELECT *, FROM employe, WHERE ville = STRASBOURG, ORDER BY ASC
        // Ou findAll() pour récupérer tt les noms
        $employes = $doctrine->getRepository(Employe::class)->findAll();
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }

    #[Route('/employe/add', name: 'add_employe')]
    #[Route('/employe/{id}edit', name: 'edit_employe')]
    // Ici on créer une function pour add une employe 
    // en paramètre : 
    // D'ABORD on ajoute ManagerRegistery $doctrine pour se connecter à la DB
    // PUIS l'objet qu'on souhaite ajouter ici employe $employe, null pour lui donner une valeur par defaut en DB
    // ENFIN Request
    public function add(ManagerRegistry $doctrine, Employe $employe = null, Request $request): Response {

        if(!$employe) {
            $employe = new Employe();
        }
        //On va construire un form avec $builder qui est dans employeType( form ), de l'entity employe
        $form = $this->createForm(EmployeType::class, $employe);
        //Ici handleRequest() va analyser les données pour les insérer dans le form
        $form->handleRequest($request);

        //SI le formulaire est envoyé ET passe les filter
        if($form->isSubmitted() && $form->isValid() ) {
            //On créer un objet employe et on lui donne (hydrate) les data du form (qu'on a dans form et employeType)
            $employe = $form->getData();
            //On récupère le manager de $doctrine pour lui faire faire la préparation et l'execution(persist et flush sont natif du manager)
            $entityManager = $doctrine->getManager();
            //On PREPARE
            $entityManager->persist($employe);
            //On EXECUTE
            $entityManager->flush();

            //Enfin on redirige vers la vue app_employe
            return $this->redirectToRoute('app_employe');
        }

        //Vue pour afficher le formulaire d'ajout
        return $this->render('employe/add.html.twig', [
            //'leNomQuonVeut' et on lui donne une vue générée par createView du form
           'formAddEmploye' => $form->createView()
        ]);
    }   

    #[Route('/employe/{id}/delete', name: 'delete_employe')]
    public function delete(ManagerRegistry $doctrine, Employe $employe): Response
    {   
        //On récupère le manager de $doctrine pour lui faire faire la préparation et l'execution(remove et flush sont natif du manager)
        $entityManager = $doctrine->getManager();
        //On enlève l'élément de la collection
        $entityManager->remove($employe);
        //On execute
        $entityManager->flush();

        //On redirige après la suppression 
        return $this->redirectToRoute('app_employe');
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
