<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Produit;

class ProduitUnitTest extends TestCase
{
	public function testIsTrue(): void
	{
		$produit = new Produit();
	
		$produit->setNom("nom")
				->setDescription("description")
				->setPrix(99.99)
				->setSlug("slug")
				->setFichier("fichier");
		
		$this->assertTrue($produit->getNom() === "nom");
		$this->assertTrue($produit->getDescription() === "description");
		$this->assertTrue($produit->getPrix() == 99.99);
		$this->assertTrue($produit->getSlug() === "slug");
		$this->assertTrue($produit->getFichier() === "fichier");
	}
	
	public function testIsFalse(): void
	{
		$produit = new Produit();
		
		$produit->setNom("nom")
				->setDescription("description")
				->setPrix(99.99)
				->setSlug("slug")
				->setFichier("fichier");
		
		$this->assertFalse($produit->getNom() === "false");
		$this->assertFalse($produit->getDescription() === "false");
		$this->assertFalse($produit->getPrix() == -1.1);
		$this->assertFalse($produit->getSlug() === "false");
		$this->assertFalse($produit->getFichier() === "false");
	}
	
	public function testIsEmpty(): void
	{
		$produit = new Produit();
		
		$this->assertEmpty($produit->getNom());
		$this->assertEmpty($produit->getDescription());
		$this->assertEmpty($produit->getPrix());
		$this->assertEmpty($produit->getSlug());
		$this->assertEmpty($produit->getFichier());
	}
}