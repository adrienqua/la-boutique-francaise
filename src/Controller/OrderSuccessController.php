<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {   
        $this->entityManager = $entityManager;
    }
    
    #[Route('/order/success/{stripeSessionId}', name: 'app_order_success')]
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId(['stripeSessionId' => $stripeSessionId]);
        if (!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('homepage');
        }

        if (!$order->isIsPaid()) {
            $order->setIsPaid(1);
            $this->entityManager->flush();

            $cart->delete();
        }
        return $this->render('order/success.html.twig', [
            'order' => $order,
        ]);
    }
}
