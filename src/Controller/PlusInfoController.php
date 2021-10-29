<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlusInfoController extends AbstractController
{

    #[Route('/plus-info/{id}', name: 'plus_info')]
    public function plusInfo(Produit $plusInfoProduit): Response
    {

        

        // return $this->redirectToRoute('plus_info', ['id' => $plusInfoProduit->getId()]);

        //         // Partie commentaires
        // // On crée le commentaire "vierge"

        // $comment = new Comments();

        // // On génére le formulaire
        // $commentForm = $this->createForm(CommentsType::class, $comment);

        // $commentForm->handleRequest($request);

        // // Traitement du formulaire
        // if($commentForm->isSubmitted() && $commentForm->isValid()){
        //     $comment->setCreatedAt(new DateTimeImmutable());
        //     $comment->setProduit($this->produit);

        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($comment);
        //     $em->flush();

        //     $this->addFlash('message', 'Votre commentaire a bien été envoyé');
        //     return $this->redirectToRoute('accueil', ['slug' => $this->produit->getSlug()]);
        // }


        return $this->render('plus-info/plus-info.html.twig', [
            'plusInfoProduit' => $plusInfoProduit,            
        ]);
    }
}
