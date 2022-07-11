<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $addresses = $entityManager->getRepository(Address::class)->findAll();

        $orders = $entityManager->getRepository(Order::class)->getPaidOrders($this->getUser());

        $user = $this->getUser();

        return $this->render('profile/index.html.twig', [
            'addresses' => $addresses,
            'user' => $user,
            'orders' => $orders
        ]);
    }
}
