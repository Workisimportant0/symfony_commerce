<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')] //juste un / en retirant accueil car comme ça on tombe directement sur accueil du site
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig');
    }
}
