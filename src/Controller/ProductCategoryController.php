<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductCategoryController extends AbstractController
{
    #[Route('/product/category/{id}', name: 'app_product_category')]
    public function index(EntityManagerInterface $entityManager, $id ): Response
    {
        $products = $entityManager->getRepository(Product::class)->findByCategory(['id' => $id ]);

        $categories = $entityManager->getRepository(Category::class)->findAll();

        $category = $entityManager->getRepository(Category::class)->findOneById(['id' => $id]);
        

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'category' => $category
        ]);
    }

    
}
