<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index( Request $request): Response
    {

        $session=$request->getSession();

        //Afficher notre Tableaux de Todo
        // Sinon je l'initialise puis j'affiche 
        if(!$session->has(name:'todos')) {
            $todos=[
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos',$todos);
            $this->addFlash(type:'info',message:"La liste des todos viens d'etre initialisée");

        }

        return $this->render(view:'todo/index.html.twig');
    }
    #[Route('/todo/{name}/{content}', name: 'todo.add')]

public function addTodo(Request $request,$name,$content){
        $session=$request->$request->getSession();

        if($session->has(name:'todos')){

        }
        else{
            $this->addFlash(type:'error',message:"La liste des todos n'est pas encore  initialiser");
        }

        return $this->redirectToRoute(route:'todo');
        //Verifier si j'ai mon tableau de todo dans la session 
         // si oui
            //si on à deja un todo avec le meme name 
               //si oui afficher erreur 
                  //si non ajouter et on affiche un message de succes  
         
         //si non
            //afficher une erreur et on va rediriger vers le controlleur index 
}

}
