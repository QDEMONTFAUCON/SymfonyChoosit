<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\PanierService;
use App\Service\LangService;
use App\Entity\Produit;
use App\Form\NombreType;
use App\Repository\ProduitRepository;

class ProduitController extends AbstractController
{
    #[Route('/', name: 'produit_index')]
    public function index(ProduitRepository $productRepository, PanierService $cartService): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $productRepository->findAllOrderedByName(),
			'taille' => $cartService->taille(),
        ]);
    }
	
	#[Route('/produit/{slug}', name: 'produit_produit')]
    public function produit(Produit $product, Request $request, PanierService $cartService): Response
    {
		$form = $this->createForm(NombreType::class);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			return $this->redirectToRoute('panier_add', [
				'id' => $request->request->get('nombre')['id'],
				'quantity' => $request->request->get('nombre')['nombre'],
			]);
		}

        return $this->render('produit/produit.html.twig', [
            'produit' => $product,
			'formNombre' => $form->createView(),
			'taille' => $cartService->taille(),
        ]);
    }
}
