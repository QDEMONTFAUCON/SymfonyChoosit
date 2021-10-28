<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProduitRepository;

class ApiProduitController extends AbstractController
{
    #[Route('/api/produits', name: 'api_produits')]
    public function produits(ProduitRepository $productRepository): Response
    {
		$products = $productRepository->findAll();
		
		return $this->json($products, 200);
    }
}