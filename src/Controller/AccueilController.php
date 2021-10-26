<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\SlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**

     * @Route("/", name="accueil")

     */ //juste un / en retirant accueil car comme ça on tombe directement sur accueil du site
    public function index(ProduitRepository $repoProduit, SlideRepository $repoSlide): Response
    {

        $listeProduits = $repoProduit->findAllJoinLibelle();

        $listeSlide = $repoSlide->findAll();

        return $this->render('accueil/index.html.twig', ["listeProduits" => $listeProduits, "listeSlide" => $listeSlide]);

        //render c'est une vue View 
    }
}
