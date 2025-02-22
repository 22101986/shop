<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('cart', name: 'cart')]
    public function index(Request $request, ManagerRegistry $doctrine, SessionInterface $session, ProductsRepository $productsRepository): Response
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        $entityManager = $doctrine->getManager();
        $validCart = new Cart;

       
        
        
        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'cart' => $productsRepository->find($id),
                'quantity' => $quantity
            ]; 
        }
        $totalPrice = 0;
        foreach($cartWithData as $item) {
            $totalPriceItem =$item['cart']->getPrice() * $item['quantity'];
            $totalPrice += $totalPriceItem;
            $name = $item['cart']->getName();
            $price = $item['cart']->getPrice();
            $validCart->setName($name);
            $validCart->setPrice($price);
            $validCart->setTotal($totalPrice);


        }
        
        $entityManager->persist($validCart);
        $entityManager->flush();
        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $totalPrice,
            
        ]);
    }
    
    #[Route('/cart/add/{id}', name: 'app_cart')]
    public function add($id, SessionInterface $session, ManagerRegistry $doctrine): Response
    {  
       $products =$doctrine->getRepository(Products::class)->findAll();
       $cart = $session->get('cart', []);
       if(!empty($cart[$id])) {
            $cart[$id]++;
       }else{
            $cart[$id] = 1;
       }
       $session->set('cart', $cart);

       return $this->render('page/page.html.twig');

    }

    #[Route('/cart/remove/{id}', name: 'remove_cart')]
    public function remove($id, SessionInterface $session, ManagerRegistry $doctrine): Response
    {  
       $products =$doctrine->getRepository(Products::class)->findAll();
       $cart = $session->get('cart', []);
       if(!empty($cart[$id])) {
            unset($cart[$id]);
       }
       $session->set('cart', $cart);

       return $this->render('page/page.html.twig');

    }
}
