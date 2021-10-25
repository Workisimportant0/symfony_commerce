<?php

namespace App\DataFixtures;

use App\Entity\Libelle;
use App\Entity\Produit;
use App\Entity\Slide;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();
        $libelleBestSeller = new Libelle();
        $libelleBestSeller->setNom("Best-seller");
        $libelleBestSeller->setCouleur("FF0000");
        $manager->persist($libelleBestSeller);

        $libelleEco = new Libelle();
        $libelleEco->setNom("Eco-responsable");
        $libelleEco->setCouleur("00FF00");
        $manager->persist($libelleEco);

        $libellePromo = new Libelle();
        $libellePromo->setNom("Promo");
        $libellePromo->setCouleur("0000FF");
        $manager->persist($libellePromo);

        $tableauLibelle = [$libelleBestSeller, $libelleEco, $libellePromo];



        $tableauImages = ["miel1.jpg", "miel2.jpg", "miel3.jpg", "miel4.jpg", "miel5.jpg", "miel6.jpg"];

        for ($i = 0; $i < 10; $i++) {
            $produit = new Produit();

            $produit->setDesignation("Miel '" . $faker->word(3) . "'") // c'est pour la la fiche produit commence par le numéro 1 et non 0
                ->setDescription($faker->text(100))
                ->setPrix($faker->randomFloat(2, 10, 40))
                ->setNomImage($faker->randomElement($tableauImages));
            //->setNomImage($tableauImages[$i + 0]); la méthode là pour avoir chaque image différent;

            $nombreLibelle = $faker->numberBetween(0, 3);

            for ($j = 0; $j < $nombreLibelle; $j++) {
                $produit->addLibelle($faker->randomElement($tableauLibelle));
            }


            $manager->persist($produit); // persist c'est pour preparer la commande        
        }

        $admin = new User();
        $admin->setPrenom("Islam")
            ->setNom("Ismailov")
            ->setEmail("ii@h.com")
            ->setPassword($this->hasher->hashPassword($admin, "motdepasse"))
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $utilisateur = new User();
        $utilisateur->setPrenom("Ibrahim")
            ->setNom("Ismailov")
            ->setEmail("ib@h.com")
            ->setPassword($this->hasher->hashPassword($utilisateur, "azerty"));

        $manager->persist($utilisateur);

        // CREATION DES SLIDES

        for ($i=1; $i <= 3; $i++){
            $slide = new Slide();
            $slide->setTitre($faker->sentence(2))
            ->setTexte($faker->text(100))
            ->setNomImage('moz' . $i . '.jpg');

            $manager->persist($slide);
        }

        $manager->flush(); //flush c'est pour enregistrer le produit
    }
}
