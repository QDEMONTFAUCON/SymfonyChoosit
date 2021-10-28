<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Repository\ProduitRepository;

class PanierService
{
	
	protected $session;
	protected $productRepository;
	
	public function __construct(SessionInterface $session, ProduitRepository $productRepository)
	{
		$this->session = $session;
		$this->productRepository = $productRepository;
	}
	
    public function add(int $id, int $quantity)
    {
		$cart = $this->session->get('panier', []);
		if(empty($cart[$id]))
		{
			$cart[$id] = 0;
		}
		$cart[$id] += $quantity;
		$this->session->set('panier', $cart);
    }
	
    public function alter(int $id, int $quantity)
    {
		$cart = $this->session->get('panier', []);
		if(!empty($cart[$id]))
		{
			$cart[$id] = $quantity;
		}
		$this->session->set('panier', $cart);
    }
	
    public function remove(int $id)
    {
		$cart = $this->session->get('panier', []);
		if(!empty($cart[$id]))
		{
			unset($cart[$id]);
		}
		$this->session->set('panier', $cart);
    }
	
    public function del()
    {
		$this->session->set('panier', []);
    }
	
	public function build() : array
    {
		$cart = $this->session->get('panier', []);
		$cartWithData = [];
		foreach($cart as $id => $quantity)
		{
			$cartWithData[] = ['produit' => $this->productRepository->find($id), 'quantite' => $quantity];
		}
		return $cartWithData;
    }
	
	public function getTotal() : float
    {
		$total = 0;
		foreach($this->build() as $item)
		{
			$total += $item['produit']->getPrix() * $item['quantite'];
		}
		return $total;
    }
	
	public function taille() : int
	{
		return count($this->session->get('panier', []));
	}
}
