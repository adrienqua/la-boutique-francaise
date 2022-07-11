<?php

namespace App\Controller;

use Stripe\Stripe;
    use App\Entity\Carrier;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/order', name: 'app_order')]
    public function index(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);




        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'orderDetails' => $cart->getFull()
        ]);
    }

    #[Route('/order/validate', name: 'app_order_validate', methods: ["POST"])]
    public function validate(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $carrier = $form->get('carrier')->getData();
            $address = $form->get('address')->getData();
            $date = new \DateTime();

            $format_address = $address->getFirstname().' '.$address->getLastname().'<br/>';
            $format_address.= $address->getPhone().'<br/>';
            $format_address.= $address->getAddress().'<br/>';
            $format_address.= $address->getZipCode().' '.$address->getCity().'<br/>';
            $format_address.= $address->getCountry();
            
            $order = new Order();
            $order->setCreatedAt($date);
            $order->setReference($date->format('dmY').'-'.uniqid());
            $order->setUser($this->getUser());
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());
            $order->setAddressName($format_address);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            
            foreach ($cart->getFull() as $product) {
                $orderDetail = new OrderDetails();
                $orderDetail->setProduct($product['product']->getName());
                $orderDetail->setQuantity($product['quantity']);
                $orderDetail->setPrice($product['product']->getPrice());
                $orderDetail->setMyOrder($order);

                $this->entityManager->persist($orderDetail);
            }
            
            $this->entityManager->flush();

            



        }



        return $this->render('order/validate.html.twig', [
            'orderDetails' => $cart->getFull(),
            'carrier' => $carrier,
            'address' => $address,
            'reference' => $order->getReference()
        ]);
    }
}
