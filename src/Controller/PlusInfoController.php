<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Repository\ProduitRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlusInfoController extends AbstractController
{

    #[Route('/plus-info', name: 'plus_info')]
    public function index(Request $request, ProduitRepository $repo): Response
    {
        // on recupere la $session pour recuperer le panier
        $session = $request->getSession();
        // s'il y a quelque chose dans le panier alors on recupere le panier sinon si c'est vide on recupere ce vide
        $ficheDetail = $session->get('plus_info', []);

        $detailFiche = [];

        $total = 0;
        $nombreProduit = 0;
        foreach ($ficheDetail as $idProduit => $quantite) {
            $nombreProduit += $quantite;
            $produit = $repo->find($idProduit);
            $total += $produit->getPrix() * $quantite;
            $detailFiche[] = [
                'produit' => $repo->find($idProduit),
                'quantite' => $quantite,
            ];
        }


        return $this->render('plus_info/index.html.twig', [
            'detailFiche' => $detailFiche,
            'total' => $total,
            'nombreProduit' => $nombreProduit,
        ]);
    }

    #[Route('/plus-infos/{id}', name: 'plus_infos')]
    public function plusInfo($id, Request $request): Response
    {
        $session = $request->getSession();
        $ficheDetail = $session->get('plus_info', []);

        //si il y a deja cet article dans le panier, on augmentera de 1 la quantité
        if (isset($ficheDetail[$id])) {
            $ficheDetail[$id]++;
            //sinon on ajoute l'id de l'article au panier, avec une quantité de 1
        } else {
            $ficheDetail[$id] = 1;
        }

        $session->set('ficheDetail', $ficheDetail);

        return $this->redirect('/plus_info');

                // Partie commentaires
        // On crée le commentaire "vierge"

        $comment = new Comments();

        // On génére le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);

        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setProduit($this->produit);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('accueil', ['slug' => $this->produit->getSlug()]);
        }


        return $this->render('plus-info/index.html.twig', [
            'commentForm' => $commentForm->createView(),
            // 'controller_name' => 'PlusInfoController',
        ]);
    }
}
