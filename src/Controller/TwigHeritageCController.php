<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigHeritageCController extends AbstractController
{
    #[Route('/twig/heritage/c', name: 'app_twig_heritage_c')]
    public function index(): Response
    {
        return $this->render('twig_heritage_c/index.html.twig', [
            'controller_name' => 'TwigHeritageCController',
        ]);
    }
}
