<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




#[Route("/todo")]

class TodoController extends AbstractController
{
    

    #[Route("/todo", name: 'todo')]
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
    #[Route("/add/{name}/{content}", name: 'todo.add')]

    public function addTodo(Request $request,$name,$content):RedirectResponse{
        $session = $request->getSession();

        if($session->has(name:'todos')){

            $todos=$session->get(name:'todos');
            if(isset($todos[$name])){
                $this->addFlash(type:'error',message:"Le todo d'id $name existe deja dans la liste ");

            }
            else{
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash(type:'succes',message:"Le todo  d'id $name à été ajouter avec succes");
                
            }

        }
        else{
            $this->addFlash(type:'error',message:"La liste des todos n'est pas encore  initialiser");
        }

         return $this->redirectToRoute(route:'todo');

            //afficher une erreur et on va rediriger vers le controlleur index 
}

#[Route("/update/{name}/{content}", name: 'todo.update')]

    public function updateTodo(Request $request,$name,$content):RedirectResponse{
        $session = $request->getSession();

        if(!$session->has(name:'todos')){

            $todos=$session->get(name:'todos');
            if(isset($todos[$name])){
                $this->addFlash(type:'error',message:"Le todo d'id $name n'existe pa dans la liste ");

            }
            else{
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash(type:'succes',message:"Le todo  d'id $name à été modifier  avec succes");
                
            }

        }
        else{
            $this->addFlash(type:'error',message:"La liste des todos n'est pas encore  initialiser");
        }

         return $this->redirectToRoute(route:'todo');

            //afficher une erreur et on va rediriger vers le controlleur index 
}

#[Route("/delete/{name}", name: 'todo.delete')]

    public function deleteTodo(Request $request,$name,$content):RedirectResponse{
        $session = $request->getSession();

        if(!$session->has(name:'todos')){

            $todos=$session->get(name:'todos');
            if(isset($todos[$name])){
                $this->addFlash(type:'error',message:"Le todo d'id $name n'existe pa dans la liste ");

            }
            else{
                unset($todos[$name]);
                $session->set('todos',$todos);
                $this->addFlash(type:'succes',message:"Le todo  d'id $name à été supprimer   avec succes");
                
            }

        }
        else{
            $this->addFlash(type:'error',message:"La liste des todos n'est pas encore  initialiser");
        }

         return $this->redirectToRoute(route:'todo');

            //afficher une erreur et on va rediriger vers le controlleur index 
}

#[Route("/reset", name: 'todo.reset')]

    public function resetTodo(Request $request):RedirectResponse{
        $session = $request->getSession();

        $session->remove(name:'todos');
         return $this->redirectToRoute(route:'todo');

            //afficher une erreur et on va rediriger vers le controlleur index 
}



}
