<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $tableauImages = ["miel1.jpg", "miel2.jpg", "miel3.jpg", "miel4.jpg", "miel5.jpg", "miel6.jpg"];

        for ($i = 0; $i < 10; $i++) {
            $produit = new Produit();

            $produit->setDesignation("Miel '" . $faker->word(3) ."'" ) // c'est pour la la fiche produit commence par le numéro 1 et non 0
                ->setDescription($faker->text(100))
                ->setPrix($faker->randomFloat(2,10,40))
                ->setNomImage($faker->randomElement($tableauImages));
                //->setNomImage($tableauImages[$i + 0]); la méthode là pour avoir chaque image différent;

            $manager->persist($produit); // persist c'est pour preparer la commande        
        }
        $manager->flush(); //flush c'est pour enregistrer le produit
    }
}
