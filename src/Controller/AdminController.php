<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**

     * @Route("/admin", name="admin")

     */
    public function index(ProduitRepository $repo): Response
    {
        $listeProduit= $repo->findAll();
        return $this->render('admin/index.html.twig', [
            'listeProduit' => $listeProduit,
        ]);
    }
        //la route s'appellera : suppression_produit

    //le chemin sera : /admin/supression-produit/42

    /**

     * @Route("/admin/supression-produit/{id}", name=" suppression_produit")

     */
    //créer la méthode permettant de supprimer un produit
    public function supprimerProduit($id, ProduitRepository $repo, ObjectManager $manager): Response {
        $repo->delete($id);
        return $this->redirect('/admin');
    }

    //$repo->delete(42)

    //

    //rediriger vers /admin



    //note : remplacer 42 par le bon identifiant
}
