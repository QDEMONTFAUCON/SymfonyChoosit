<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\CartService;
use App\Form\QuantityType;

class CartController extends AbstractController
{
    #[Route('/panier/{id}', name: 'cart_index')]
    public function index(int $id = null, Request $request, CartService $cartService): Response
    {
		if($id)
		{
			$form = $this->createForm(QuantityType::class);
			$form->handleRequest($request);
			if($form->isSubmitted() && $form->isValid())
			{
				return $this->redirectToRoute('cart_alter', [
					'id' => $request->request->get('quantity')['id'],
					'quantity' => $request->request->get('quantity')['quantity'],
				]);
			}
		
			return $this->render('cart/index.html.twig', [
				'id' => $id,
				'cart' => $cartService->build(),
				'total' => $cartService->getTotal(),
				'formQuantity' => $form->createView(),
				'length' => $cartService->length(),
			]);
		}
		
        return $this->render('cart/index.html.twig', [
			'id' => -1,
			'cart' => $cartService->build(),
			'total' => $cartService->getTotal(),
			'length' => $cartService->length(),
        ]);
    }
	
	#[Route('/ajouter/panier/{id}/{quantity}', name: 'cart_add')]
    public function add(int $id, int $quantity, CartService $cartService): Response
    {
		$cartService->add($id, $quantity);
		
		return $this->redirectToRoute('product_index');
    }
	
	#[Route('/modifier/panier/{id}/{quantity}', name: 'cart_alter')]
    public function alter(int $id, int $quantity, CartService $cartService): Response
    {
		$cartService->alter($id, $quantity);
		
		return $this->redirectToRoute('cart_index');
    }
	
	#[Route('/retirer/panier/{id}', name: 'cart_remove')]
    public function remove(int $id, CartService $cartService): Response
    {
		$cartService->remove($id);
		
		return $this->redirectToRoute('cart_index');
    }

	#[Route('/supprimer/panier', name: 'cart_drop')]
    public function drop(CartService $cartService): Response
    {
		$cartService->drop();
		
		return $this->redirectToRoute('cart_index');
    }
}
