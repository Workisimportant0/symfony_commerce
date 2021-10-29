<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Produit;
use App\Form\CommentsType;
use App\Repository\ProduitRepository;
use App\Repository\SlideRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**

     * @Route("/", name="accueil")

     */ //juste un / en retirant accueil car comme ça on tombe directement sur accueil du site
    public function index(ProduitRepository $repoProduit, SlideRepository $repoSlide, Request $request): Response
    {

        $listeProduits = $repoProduit->findAllJoinLibelle();

        $listeSlide = $repoSlide->findAll();

        

        return $this->render('accueil/index.html.twig', ["listeProduits" => $listeProduits, "listeSlide" => $listeSlide, 
    ]);

        //render c'est une vue View 
    }

    // #[Route('/plus-info/{id}', name: 'plus_info')]
    // public function plusInfo(Produit $plusInfoProduit): Response
    // {

    //     // // Partie commentaires
    //     // // On crée le commentaire "vierge"

    //     // $comment = new Comments();

    //     // // On génére le formulaire
    //     // $commentForm = $this->createForm(CommentsType::class, $comment);

    //     // $commentForm->handleRequest($request);

    //     // // Traitement du formulaire
    //     // if($commentForm->isSubmitted() && $commentForm->isValid()){
    //     //     $comment->setCreatedAt(new DateTimeImmutable());
    //     //     $comment->setProduit($this->produit);

    //     //     $em = $this->getDoctrine()->getManager();
    //     //     $em->persist($comment);
    //     //     $em->flush();

    //     //     $this->addFlash('message', 'Votre commentaire a bien été envoyé');
    //     //     return $this->redirectToRoute('accueil', ['slug' => $this->produit->getSlug()]);
    //     // }

    //     return $this->redirectToRoute('plus_info', [':id' => $plusInfoProduit->getId()]);

    //     return $this->render('plus-info/plusInfo.html.twig', [

    //         'plusInfoProduit' => $plusInfoProduit,            

    //     ]);

    // }

}
