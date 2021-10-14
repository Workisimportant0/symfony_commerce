<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
/**

     * @Route("/panier", name="panier")

     */  
     public function index(Request $request, ProduitRepository $repo): Response
    {
        // on recupere la $session pour recuperer le panier
        $session = $request->getSession();
        // s'il y a quelque chose dans le panier alors on recupere le panier sinon si c'est vide on recupere ce vide
        $panier = $session->get('panier', []);

        $detailPanier = [];

        $total = 0;
        $nombreProduit = 0;
        foreach ($panier as $idProduit => $quantite ){
            $nombreProduit += $quantite;
            $produit = $repo->find($idProduit);
            $total += $produit->getPrix() * $quantite;
            $detailPanier[]= [
                'produit' => $repo->find($idProduit),
                'quantite' => $quantite,
            ];
        }


        return $this->render('panier/index.html.twig', [
            'detailPanier' => $detailPanier,
            'total' => $total,
            'nombreProduit' => $nombreProduit,
        ]);
    }
    


/**

     * @Route("/ajout-panier/{id}", name="ajout_panier")

     */
    public function ajoutPanier($id, Request $request): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        //si il y a deja cet article dans le panier, on augmentera de 1 la quantité
        if (isset($panier[$id])) {
            $panier[$id]++;
            //sinon on ajoute l'id de l'article au panier, avec une quantité de 1
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirect('/panier');
    }
}
