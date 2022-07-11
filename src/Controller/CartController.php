<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart, EntityManagerInterface $entityManager): Response
    {
       
        

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);   

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/subtract/{id}', name: 'app_subtract_to_cart')]
    public function subtract(Cart $cart, $id): Response
    {
        $cart->subtract($id);
        

        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/remove/{id}', name: 'app_removeItem_cart')]
    public function removeItem(Cart $cart, $id): Response
    {
        $cart->removeItem($id);
        

        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/delete', name: 'app_delete_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->delete();
        

        return $this->redirectToRoute('app_cart');
    }

}
