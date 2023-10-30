<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    // afficher toutes les personnes 
    #[Route('/', name:'personne.List')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class); 
    
        $personnes = $repository->findAll();
    
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }
    
    #[Route('/alls/{page?1}/{nbre?12}', name:'personne.alls')]
    public function indexAlls(ManagerRegistry $doctrine , $page,$nbre): Response
    {
        $repository = $doctrine->getRepository(Personne::class); 
        $nbpersonne = $repository->Count([]);

        $nbrepage=ceil($nbpersonne/$nbre);
     
    
        $personnes = $repository->findBy([],[],$nbre, offset:($page-1)*$nbre);
    
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'nbrePage'=>$nbrepage,
            'page'=>$page
        ]);
    }



    #[Route('/{id<\d+>}', name:'personne.detail')]
   // detail d'une personne
    public function detail(Personne $personne =null): Response
    {
        
        if(!$personne){
            $this->addFlash(type:'error',message:"la personne n'exsite pas ");
            return $this->redirectToRoute('personne.List');
        }
        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    
      
    }


    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager=$doctrine->getManager();
        $personne= new Personne();
        $personne->setFirstname('isaac');
        $personne-> setname('tchantcho');
        $personne->setAge(27);
        

        //Ajoute l'àperation d'insertion de la personne dans ma transaction
        $entityManager->persist($personne);
        //exécute la transaction 
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }
    #[Route('/delete/{id}', name:'personne.delete')]
    public function deletePersonne( personne $personne=null, ManagerRegistry $doctrine): RedirectResponse {

    if ($personne) {
        $manager=$doctrine->getManager();
        //ajouter la fonction de suppression dans la transaction 
        $manager->remove($personne);
        //executer la transaction
        $manager->flush();
        $this->addFlash(type: 'sucess', message:"la personne à été supprimé avec succès");
    
    }else{
        $this->addFlash(type:'error', message:" la personne est innexistante ");
    }
        // Récupérer la personne 
           //si la personne exixte=> le supprimer et retourner un flasMessage de succès 
           //si non retourner un flashMessage d'erreur 
    return $this-> redirectToRoute(route:'personne.list.alls');
        
    }

}

