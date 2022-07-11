<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Slider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $featuredProducts = $entityManager->getRepository(Product::class)->findBy(['isFeatured' => true]);

        $sliders = $entityManager->getRepository(Slider::class)->findBy(['isActive' => true]);

        return $this->render('home/index.html.twig', [
            'featuredProducts' => $featuredProducts,
            'sliders' => $sliders
        ]);
    }
}
