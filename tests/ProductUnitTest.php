<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductUnitTest extends TestCase
{
	public function testIsTrue(): void
	{
		Product $product = new Product();
	
		$product->setName("nom")
				->setDescription("description")
				->setPrice(99.99)
				->setSlug("slug")
				->setFile("fichier");
		
		$this->assertTrue($product->getName() === "nom");
		$this->assertTrue($product->getDescription() === "description");
		$this->assertTrue($product->getPrice() == 99.99);
		$this->assertTrue($product->getSlug() === "slug");
		$this->assertTrue($product->getFile() === "fichier");
	}
	
	public function testIsFalse(): void
	{
		Product $product = new Product();
		
		$product->setName("nom")
				->setDescription("description")
				->setPrice(99.99)
				->setSlug("slug")
				->setFile("fichier");
		
		$this->assertFalse($product->getName() === "false");
		$this->assertFalse($product->getDescription() === "false");
		$this->assertFalse($product->getPrice() == -1.1);
		$this->assertFalse($product->getSlug() === "false");
		$this->assertFalse($product->getFile() === "false");
	}
	
	public function testIsEmpty(): void
	{
		Product $product = new product();
		
		$this->assertEmpty($product->getName());
		$this->assertEmpty($product->getDescription());
		$this->assertEmpty($product->getPrice());
		$this->assertEmpty($product->getSlug());
		$this->assertEmpty($product->getFile());
	}
}