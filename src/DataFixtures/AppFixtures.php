<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$faker = Factory::create('fr_FR');
		
		for($p = 0; $p < 12; $p++)
		{
			$product = new Product();
			$product->setName($faker->words(3, true))
					->setDescription($faker->text(300))
					->setPrice($faker->randomFloat(2, 10, 10000))
					->setSlug($faker->slug(2))
					->setFile($faker->imageUrl(360, 360, 'products', true));
					
			$manager->persist($product);
		}

        $manager->flush();
    }
}
