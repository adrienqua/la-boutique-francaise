<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(EntityManagerInterface $entityManager ): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    #[Route('/products/{id}', name: 'app_product_details')]
    public function details(EntityManagerInterface $entityManager, $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->findOneBy(array('id' => $id));

        $featuredProducts = $entityManager->getRepository(Product::class)->findBy(['isFeatured' => true]);
        

        return $this->render('product/details.html.twig', [
            'product' => $product,
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
