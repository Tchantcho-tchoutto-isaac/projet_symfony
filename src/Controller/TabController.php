<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb?5}', name: 'tab')]
    public function index($nb): Response
    {
         $notes=[];
        for($i=0; $i<$nb; $i++){    
         $notes[]= rand(0,5);
        }
        return $this->render('tab/index.html.twig', [
            'notes' => $notes,
        ]);
    }

    
    #[Route('/tab/users', name: 'tab.users')]
    public function users ():Response 
    {
        $users=[
            ['firstname'=>'aymen','name'=>'sellouti','age'=>'15'],
            ['firstname'=>'unkut','name'=>'victime','age'=>'59'],
            ['firstname'=>'isaac','name'=>'tchantcho','age'=>'28']
        ];
        
        return $this->render('tab/users.html.twig', [
            'users'=>$users]);
    }

}
