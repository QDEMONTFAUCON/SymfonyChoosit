<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

use App\Repository\ProductRepository;

class CartService
{
	
	public function __construct(
		protected RequestStack $requestStack,
		protected ProductRepository $productRepository,
	) {}
	
    public function add(int $id, int $quantity) : void
    {
		$session = $this->requestStack->getSession();
		$cart = $session->get('cart', []);
		if(empty($cart[$id]))
		{
			$cart[$id] = 0;
		}
		$cart[$id] += $quantity;
		$session->set('cart', $cart);
    }
	
    public function alter(int $id, int $quantity) : void
    {
		$session = $this->requestStack->getSession();
		$cart = $session->get('cart', []);
		if(!empty($cart[$id]))
		{
			$cart[$id] = $quantity;
		}
		$session->set('cart', $cart);
    }
	
    public function remove(int $id) : void
    {
		$session = $this->requestStack->getSession();
		$cart = $session->get('cart', []);
		if(!empty($cart[$id]))
		{
			unset($cart[$id]);
		}
		$session->set('cart', $cart);
    }
	
    public function drop() : void
    {
		$session = $this->requestStack->getSession();
		$session->set('cart', []);
    }
	
	public function build() : array
    {
		$session = $this->requestStack->getSession();
		$cart = $session->get('cart', []);
		$cartWithData = [];
		foreach($cart as $id => $quantity)
		{
			$cartWithData[] = ['product' => $this->productRepository->find($id), 'quantity' => $quantity];
		}
		return $cartWithData;
    }
	
	public function getTotal() : float
    {
		$total = 0;
		foreach($this->build() as $item)
		{
			$total += $item['product']->getPrice() * $item['quantity'];
		}
		return $total;
    }
	
	public function length() : int
	{
		$session = $this->requestStack->getSession();
		return count($session->get('cart', []));
	}
}
