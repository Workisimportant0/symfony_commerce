<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(Request $request, ProduitRepository $repo): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        $detailPanier = [];

        foreach ($panier as $idProduit => $quantite ){
            $detailPanier[]= [
                'produit' => $repo->find($idProduit),
                'quantite' => $quantite,
            ];
        }


        return $this->render('panier/index.html.twig', [
            'detailPanier' => $detailPanier,
        ]);
    }

    #[Route('/ajout-panier/{id}', name: 'ajout_panier')]
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
