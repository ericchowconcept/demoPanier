<?php 

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private  $repo;

    private $rs;

    // *injection de déoendances hors d'un controller : constructeur
    public function __construct(ProductRepository $repo, RequestStack $rs)
    {
        $this->rs = $rs;
        $this->repo = $repo;
    }

    public function add($id)
    {
      
         $session = $this->rs->getSession();

         $cart = $session->get('cart', []);
       
 
         $qt = $session->get('qt', 0);
 
 
      
         if(!empty($cart[$id]))
         {
             $cart[$id]++;
             $qt++;
         }else{
             $cart[$id]= 1;
             $qt++;
            
         }
 
         $session->set('qt', $qt);
         $session->set('cart', $cart);
        
    }

    public function remove($id)
    {
        $session = $this->rs->getSession();
        $cart = $session ->get('cart',[]);
        $qt = $session->get('qt', 0);

        if(!empty($cart[$id]))
        {
            $qt -= $cart[$id];
            unset($cart[$id]);

        }

        if($qt<0)
        {
            $qt =0;
        }

        $session->set('qt', $qt);
        $session->set('cart', $cart);
    }

    public function cartWithData()
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);

       
        $cartWithData = [];
     
       
        foreach($cart as $id => $quantity)
        {
            $produit = $this->repo->find($id);
            $cartWithData[] = [
                'product' =>  $produit,
                'quantity' => $quantity
            ];
           
        }

        return $cartWithData;
    }

    public function total()
    {
        $cartWithData = $this->cartWithData();
        $total = 0;

        foreach($cartWithData as $item )
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $total;
    }
}



