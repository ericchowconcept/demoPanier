<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response
    {

        $cartWithData = $cs -> cartWithData();
        $total = $cs->total();
        // $session = $rs->getSession();
        // $cart = $session->get('cart', []);

        // *je vais créer un nouveau tableau qui contiendra des objets products et les quantités de chaque objet
        // $cartWithData = [];
        // $total = 0;
        // //* Pour chaque $id qui se trouve dans mon tableau $cart, j'ajoute une case au tableau $cartWithData
        // *dans chacune de ses cases il y aura un tableau associatif contenant 2 case: une pour product et une pour quantity
        // foreach($cart as $id => $quantity)
        // {
        //     $produit = $repo->find($id);
        //     $cartWithData[] = [
        //         'product' =>  $produit,
        //         'quantity' => $quantity
        //     ];
        //     $total += $produit->getPrice() * $quantity;
        // }
        return $this->render('cart/index.html.twig',[
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name:'cart_add' )]
    public function add($id, CartService $cs) : Response 
    // *indice id et valeur quantity
    //*service accès, dédié à la session
    {
        // *Nous récuperons ou créons une session grace à la class RequestStack (service)
        // $session = $rs->getSession();

        // $cart = $session->get('cart', []);
        // *Je récupère l'attribut session 'cart', s'il existe ou un tableau vide

        // $qt = $session->get('qt', 0);


        // *si l'id est présent dans mon cart
        // if(!empty($cart[$id]))
        // {
        //     $cart[$id]++;
        //     $qt++;
        // }else{
        //     $cart[$id]= 1;
        //     $qt++;
            // *dans mon tableau $cart, à la case $id, je donne la valeur 1
        // }

        // $session->set('qt', $qt);
        // $session->set('cart', $cart);
        // *je sauvegard l'etat de mon panier à l'attribut de session 'cart'

        $cs->add($id);
        return $this->redirectToRoute('app_product');

    }

    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove($id, CartService $cs) : Response
    {
        // $session = $rs->getSession();
        // $cart = $session ->get('cart',[]);
        // $qt = $session->get('qt', 0);

        // if(!empty($cart[$id]))
        // {
        //     $qt -= $cart[$id];
        //     unset($cart[$id]);

        // }

        // if($qt<0)
        // {
        //     $qt =0;
        // }

        // $session->set('qt', $qt);
        // $session->set('cart', $cart);
        // !deplacé dans CartService

        $cs->remove($id);
        return $this->redirectToRoute('app_cart');

    }
}
