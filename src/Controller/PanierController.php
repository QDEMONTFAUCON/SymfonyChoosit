<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\PanierService;
use App\Form\NombreType;

class PanierController extends AbstractController
{
    #[Route('/panier/{id}', name: 'panier_index')]
    public function index(int $id = null, Request $request, PanierService $cartService): Response
    {
		if($id)
		{
			$form = $this->createForm(NombreType::class);
			$form->handleRequest($request);
			if($form->isSubmitted() && $form->isValid())
			{
				return $this->redirectToRoute('panier_alter', [
					'id' => $request->request->get('nombre')['id'],
					'quantity' => $request->request->get('nombre')['nombre'],
				]);
			}
		
			return $this->render('panier/index.html.twig', [
				'id' => $id,
				'panier' => $cartService->build(),
				'total' => $cartService->getTotal(),
				'formNombre' => $form->createView(),
				'taille' => $cartService->taille(),
			]);
		}
		
        return $this->render('panier/index.html.twig', [
			'id' => -1,
			'panier' => $cartService->build(),
			'total' => $cartService->getTotal(),
			'taille' => $cartService->taille(),
        ]);
    }
	
	#[Route('/add/panier/{id}/{quantity}', name: 'panier_add')]
    public function add(int $id, int $quantity, PanierService $cartService): Response
    {
		$cartService->add($id, $quantity);
		
		return $this->redirectToRoute('produit_index');
    }
	
	#[Route('/alter/panier/{id}/{quantity}', name: 'panier_alter')]
    public function alter(int $id, int $quantity, PanierService $cartService): Response
    {
		$cartService->alter($id, $quantity);
		
		return $this->redirectToRoute('panier_index');
    }
	
	#[Route('/remove/panier/{id}', name: 'panier_remove')]
    public function remove(int $id, PanierService $cartService): Response
    {
		$cartService->remove($id);
		
		return $this->redirectToRoute('panier_index');
    }

	#[Route('/del/panier', name: 'panier_del')]
    public function del(PanierService $cartService): Response
    {
		$cartService->del();
		
		return $this->redirectToRoute('panier_index');
    }
}
