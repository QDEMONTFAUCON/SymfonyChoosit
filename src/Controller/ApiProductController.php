<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductRepository;

class ApiProductController extends AbstractController
{
    #[Route('/api/produits', name: 'api_products')]
    public function products(ProductRepository $productRepository): Response
    {
		$products = $productRepository->findAll();
		
		return $this->json($products, 200);
    }
}