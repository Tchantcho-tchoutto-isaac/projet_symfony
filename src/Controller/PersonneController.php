<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/personne")
 */
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

    // afficher toutes les personnes 
    #[Route('/alls/age/{ageMin}/{ageMax}', name:'personne.List.age')]
    public function PersonneByAge(ManagerRegistry $doctrine,$ageMin, $ageMax): Response
    {
        $repository = $doctrine->getRepository(Personne::class); 
        $personnes=$repository->FindPersonneByInterval($ageMin,$ageMax);
    
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }

    // afficher  les Statistique  personnes 
    #[Route('/stats/age/{ageMin}/{ageMax}', name:'personne.List.age')]
    public function statsPersonneByAge(ManagerRegistry $doctrine,$ageMin, $ageMax): Response
    {
        $repository = $doctrine->getRepository(Personne::class); 
        $stats=$repository->StatsPersonneByInterval($ageMin,$ageMax);
    
        return $this->render('personne/stats.html.twig', ['stats' => $stats[0],
        'ageMin'=>$ageMin, 
        'ageMax'=>$ageMax] );
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
            return $this->redirectToRoute('alls');
        }
        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    
      
    }

    #[Route('/edit/{id?0}', name: 'personne.edit')]
    public function addPersonne(ManagerRegistry $doctrine, Personne $personne = null, Request $request, SluggerInterface $slugger): Response
    {
        $new = false;
        if (!$personne) {
            $personne = new Personne();
            $new = true;
        }
    
        // Supprimez le bloc "else" existant pour éviter la confusion
        $form = $this->createForm(PersonneType::class, $personne);
    
        // Mon formulaire va aller traiter la requête
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('Photo')->getData();
    
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('Personne_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $personne->setImage($newFilename);
            }
    
            $manager = $doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
    
            if ($new) {
                $message = "a été ajouté avec succès";
            } else {
                $message = "a été mis à jour avec succès";
            }
            $this->addFlash('success', $message);
    
            return $this->redirectToRoute('personne.List');
        }
    
        return $this->render('personne/add-personne.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    




/*
    #[Route('/edit/{id}', name: 'personne.edit')]
    public function addPersonne(ManagerRegistry $doctrine , personne $personne = null, Request $request,SluggerInterface $slugger): Response
    {

        $new =false;
        if(!$personne) {
            $personne = new personne();
            $new = true;
        } 

        $entityManager=$doctrine->getManager();
        $personne=new personne();
     
        $form= $this->createForm(PersonneType::class,$personne );
        
        // mon formulaire va aller traiter la requete 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo=$form->get('Photo')->getData();

            if($photo){
                $originalFilename=pathinfo($photo->getClientOriginalName(), flags:PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename=$safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                try{
                    $photo->move(
                        $this->getParameter('Personne_directory'),
                        $newFilename
                    
                    );
                } catch(FileException $e){}
                $personne->setImage($newFilename);
            }

            $manager= $doctrine->getManager();
            $manager->persist($personne);
            $entityManager->flush();
            
            if($new){
                $message="à été ajouté avec succès";
            }else{
                $message="à été mis à jour avec succès";
            }
            $this->addFlash(type:'success',message:$message);

            return $this-> redirectToRoute(route: 'personne.List');
       
        
    }else{
        return $this->render('personne/add-personne.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

*/


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
    return $this-> redirectToRoute(route: 'personne.List');
        
    }

    #[Route('/update/{id}{name}{firstname}/{age}', name:'personne.update')]
    public function updatePersonne(personne $personne =null,ManagerRegistry $doctrine , $name,$firstname,$age )
     {
        if($personne){
            $personne->setName($name);
            $personne->setFirstname($name);
            $personne->setAge($name);
            $manager=$doctrine->getManager();
            $manager->persist($personne); 

            $manager->flush();
            $this->addFlash(type: 'sucess', message:"la personne à été mise à jour  avec succès");
        }else {

        $this->addFlash(type:'error', message:" la personne est innexistante ");

        }
        return $this-> redirectToRoute(route: 'personne.List');
    }
    

}

