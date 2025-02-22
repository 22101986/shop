<?php
 
namespace App\Controller;
 
use Stripe\Charge;
use Stripe;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(CartRepository $cart, SessionInterface $session, ProductsRepository $productsRepository): Response
    {   
        $cart = $cart->findAll();
        $cart = $session->get('cart', []);

        $cartWithData = [];
        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'cart' => $productsRepository->find($id), 
                'quantity' => $quantity
            ]; 
        }
        $totalPrice = 0;
        $datas = [];
        $quantitys = [];
        $name;
        $price;
        $quantity;

        foreach($cartWithData as $item) {
            $totalPriceItem = $item['cart']->getPrice() * $item['quantity'];
            $totalPrice += $totalPriceItem;
            array_push($datas,[$item['cart']->getName(), $price = $item['cart']->getPrice(), $item['quantity']] );
            $name = $item['cart']->getName();
            $price = $item['cart']->getPrice();
            $quantity = $item['quantity'];

        }

        
        


        // return dd($datas, $name, $price, $quantity);
        return $this->render('payment/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'items' => $cartWithData,
            'name' => $name,
            'price' => $price,
            'datas' => $datas,
            'total' => $totalPrice
        ]);
    }
 
 
    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request, SessionInterface $session, CartRepository $cart, ProductsRepository $productsRepository)
    {   
        $cart = $cart->findAll();
        $cart = $session->get('cart', []);

        $cartWithData = [];
        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'cart' => $productsRepository->find($id),
                'quantity' => $quantity
            ]; 
        }
        $totalPrice = 0;
        $datas = [];
        $quantitys = [];
        $name;
        $price;
        $quantity;

        foreach($cartWithData as $item) {
            $totalPriceItem =$item['cart']->getPrice() * $item['quantity'];
            $totalPrice += $totalPriceItem;
            array_push($datas,[$item['cart']->getName(), $price = $item['cart']->getPrice(), $item['quantity']] );
            $name = $item['cart']->getName();
            $price = $item['cart']->getPrice();
            $quantity = $item['quantity'];

        }

        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Stripe\Charge::create ([
                "amount" => $totalPrice * 100,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'),
                "description" => "Binaryboxtuts Payment Test"
        ]);
        $this->addFlash('success', 'Paiement accepté');

        return $this->redirectToRoute('app_stripe', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'total' => $totalPrice

        ], Response::HTTP_SEE_OTHER);
    }
}

