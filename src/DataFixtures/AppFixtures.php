<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use App\Entity\Produit;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$faker = Factory::create('fr_FR');
		
		for($p = 0; $p < 12; $p++)
		{
			$produit = new Produit();
			$produit->setNom($faker->words(3, true))
					->setDescription($faker->text(300))
					->setPrix($faker->randomFloat(2, 10, 10000))
					->setSlug($faker->slug(2))
					->setFichier($faker->imageUrl(360, 360, 'products', true));
					
			$manager->persist($produit);
		}

        $manager->flush();
    }
}
