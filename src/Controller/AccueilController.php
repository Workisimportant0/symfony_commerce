<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**

     * @Route("/", name="accueil")

     */ //juste un / en retirant accueil car comme ça on tombe directement sur accueil du site
    public function index(ProduitRepository $repo): Response
    {
        $listeProduits = $repo->findAll();

        return $this->render('accueil/index.html.twig', ["listeProduits" => $listeProduits,]);
        //render c'est une vue View 
    }
}
