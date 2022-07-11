<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/order/create-session/{reference}', name: 'app_stripe')]
    public function index(EntityManagerInterface $entityManager,Cart $cart, $reference): Response
    {

        $order = $entityManager->getRepository(Order::class)->findOneByReference(['reference' =>  $reference]);

        Stripe::setApiKey('sk_test_51LJqSlHqGgc3bylhMvMmKQv5cPA66pEUsBP8VcRSs4ZyjsDhNNzMY1AB79rJZS9nd0kjQNHi0TH5P2rMcRkIken800ufLi7twL');
        
        $YOUR_DOMAIN = 'https://localhost:8000';


        $stripe_cart = [];
        foreach ($cart->getFull() as $product) {
            $stripe_cart[] = [ 
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice()*100,
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [$YOUR_DOMAIN."/img/products/".$product['product']->getImage()],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];
        }

        //Ajout des frais de ports
        $stripe_cart[]  = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice()*100,
                'product_data' => [
                    'name' => 'Frais de port '.$order->getCarrierName(),
                    'images' => [],
                ],
            ],
            'quantity' => 1,
        ];  
  


        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [
                $stripe_cart
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/order/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/order/cancel/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();
        
        
        return $this->redirect($checkout_session->url);

    }
}
