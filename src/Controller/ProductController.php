<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\CartService;
use App\Form\QuantityType;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index')]
    public function index(ProductRepository $productRepository, CartService $cartService): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAllOrderedByName(),
			'length' => $cartService->length(),
        ]);
    }
	
	#[Route('/produit/{slug}', name: 'product_product')]
    public function product(Product $product, Request $request, CartService $cartService): Response
    {
		$form = $this->createForm(QuantityType::class);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			return $this->redirectToRoute('cart_add', [
				'id' => $request->request->get('quantity')['id'],
				'quantity' => $request->request->get('quantity')['quantity'],
			]);
		}

        return $this->render('product/product.html.twig', [
            'product' => $product,
			'formQuantity' => $form->createView(),
			'length' => $cartService->length(),
        ]);
    }
}

