<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Slide;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\SlideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class AdminController extends AbstractController
{
    /**
     
     * @Route("/admin-produit", name="admin_produit")
     * @Route("/admin", name="admin")
     
     */
    public function administrationProduit(ProduitRepository $repoProduit): Response
    {
        $listeProduit = $repoProduit->findAll();

        $listeProduitParCategorie = [];

        foreach ($listeProduit as $produit) {
            $nomCategorie = $produit->getCategorie()->getNom();

            if (!isset($listeProduitParCategorie[$nomCategorie])) {

                $listeProduitParCategorie[$nomCategorie] = [];

            }
            
            $listeProduitParCategorie[$nomCategorie][] = $produit;

        }




        return $this->render('admin/admin-produit.html.twig', [
            'listeProduitParCategorie' => $listeProduitParCategorie,
        ]);
    }
    /**

     * @Route("/admin/slide", name="admin_slide")

     */
    public function administrationSlide(SlideRepository $repoSlide): Response
    {

        $listeSlide = $repoSlide->findAll();

        return $this->render('admin/admin-slide.html.twig', [
            'listeSlide' => $listeSlide,
        ]);
    }

    /**

     * @Route("/admin/categorie", name="admin_categorie")

     */
    public function administrationCategories(CategorieRepository $repoCategorie): Response
    {
        $listeCategorie = $repoCategorie->findAll();
        return $this->render('admin/admin-categorie.html.twig', [
            'listeCategorie' => $listeCategorie,
        ]);
    }

    //la route s'appellera : suppression_produit

    //le chemin sera : /admin/supression-produit/42

    /**

     * @Route("/admin/supression-produit/{id}", name="supression_produit")

     */
    //créer la méthode permettant de supprimer un produit
    public function supprimerProduit($id, EntityManagerInterface $manager): Response
    {

        $produit = $manager->getReference('App\\Entity\\Produit', $id);
        $manager->remove($produit);
        $manager->flush();
        return $this->redirect('/admin');
    }
    /**

     * @Route("/admin/creation-produit", name="creation_produit")
     * @Route("/admin/edition-produit/{id}", name="edition_produit")

     */

    public function editionProduit(Produit $produit = null, Request $request, EntityManagerInterface $manager): Response

    {



        if ($produit == null) {

            $produit = new Produit();
        }



        $formulaire = $this->createFormBuilder($produit)
            ->add('designation', TextType::class, ['label' => 'Désignation', 'attr' => ['placeholder' => 'Nom du produit', 'class' => 'form-control'], 'row_attr' => ['class' => 'form-group'],])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
            ])
            ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Description du produit', 'class' => 'form-control'], 'row_attr' => ['class' => 'form-group'],])
            ->add('prix', null, ['attr' => ['label' => 'Prix', 'placeholder' => 'Prix TTC', 'class' => 'form-control'], 'row_attr' => ['class' => 'form-group'],])
            ->add('nomImage', FileType::class, ['label' => 'Image', 'mapped' => false, 'required' => false, 'attr' => ['class' => 'form-control'], 'constraints' => [new File(['mimeTypes' => ['image/jpeg', 'image/png'], 'mimeTypesMessage' => "Format jpg ou png uniquement"])]])->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['btn btn-success'],])->getForm();



        $formulaire->handleRequest($request);



        //si l'utilisateur à cliqué sur le bouton enregistrer

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {



            $image = $formulaire->get("nomImage")->getData();



            if ($image) {

                $nomOriginal = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                $nomUnique = $nomOriginal . '-' . uniqid() . '.' . $image->guessExtension();

                $image->move('uploads', $nomUnique);

                $produit->setNomImage($nomUnique);
            }
            $manager->persist($produit);

            $manager->flush();

            return $this->redirect('/admin');
        }



        $vueFormulaire = $formulaire->createView();



        return $this->render('admin/edition-produit.html.twig', ['produit' => $produit, 'vueFormulaire' => $vueFormulaire]);
    }


    /**

     * @Route("/admin/supression-slide/{id}", name="supression_slide")

     */
    //créer la méthode permettant de supprimer un produit
    public function supprimerSlide($id, EntityManagerInterface $manager): Response
    {

        $slide = $manager->getReference('App\\Entity\\Slide', $id);
        $manager->remove($slide);
        $manager->flush();
        return $this->redirect('/admin');
    }

    /**

     * @Route("/admin/creation-slide", name="creation_slide")
     * @Route("/admin/edition-slide/{id}", name="edition_slide")

     */

    public function editionSlide(Produit $slide = null, Request $request, EntityManagerInterface $manager): Response

    {



        if ($slide == null) {

            $slide = new Slide();
        }



        $formulaire = $this->createFormBuilder($slide)->add('titre', TextType::class, ['label' => 'Titre', 'attr' => ['placeholder' => 'Nom du slide', 'class' => 'form-control'], 'row_attr' => ['class' => 'form-group'],])->add('texte', TextareaType::class, ['attr' => ['placeholder' => 'Description du slide', 'class' => 'form-control'], 'row_attr' => ['class' => 'form-group'],])->add('nomImage', FileType::class, ['label' => 'Image', 'mapped' => false, 'required' => false, 'attr' => ['class' => 'form-control'], 'constraints' => [new File(['mimeTypes' => ['image/jpeg', 'image/png'], 'mimeTypesMessage' => "Format jpg ou png uniquement"])]])->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['btn btn-success'],])->getForm();



        $formulaire->handleRequest($request);



        //si l'utilisateur à cliqué sur le bouton enregistrer

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {



            $image = $formulaire->get("nomImage")->getData();



            if ($image) {

                $nomOriginal = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                $nomUnique = $nomOriginal . '-' . uniqid() . '.' . $image->guessExtension();

                $image->move('uploads', $nomUnique);

                $slide->setNomImage($nomUnique);
            }
            $manager->persist($slide);

            $manager->flush();

            return $this->redirect('/admin');
        }



        $vueFormulaire = $formulaire->createView();



        return $this->render('admin/edition-slide.html.twig', ['slide' => $slide, 'vueFormulaire' => $vueFormulaire]);
    }
}
