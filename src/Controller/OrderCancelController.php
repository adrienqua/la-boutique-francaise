<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {   
        $this->entityManager = $entityManager;
    }
    
    #[Route('/order/cancel/{stripeSessionId}', name: 'app_order_cancel')]
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId(['stripeSessionId' => $stripeSessionId]);
        
        if (!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('homepage');
        }

        return $this->render('order/cancel.html.twig', [
            'order' => $order,
        ]);
    }
}
