<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig', );
    }

    
    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'firstname' => 'isaac ',
            'name'=>'Tchantcho'
        ]);
    }


     public function sayHello($name,$firstname): Response
    {
        return $this->render('first/hello.html.twig', [
            'nom' => $name,
            'prenom' =>$firstname

        ]);
    }
   #[Route('multi/{entier1}/{entier2}',
       name:'multiplication',
       requirements:['entier1'=>'\d+','entier2'=>'\d+']
       )]
    public function multiplicatio($entier1,$entier2){
        $resultat=$entier1*$entier2;
        return new Response(content:"<h1>$resultat</h1>");
    }
}
