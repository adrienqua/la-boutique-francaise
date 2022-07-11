<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{
    #[Route('/account/order/{reference}', name: 'app_account_order')]
    public function index(EntityManagerInterface $entityManager, $reference): Response
    {
        $order = $entityManager->getRepository(Order::class)->findOneByReference(['reference' => $reference]);



        return $this->render('account_order/index.html.twig', [
            'order' => $order,
        ]);
    }
}
