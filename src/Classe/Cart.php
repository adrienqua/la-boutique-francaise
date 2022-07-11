<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart {

    private $requestStack;
    private $session;
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager) {
        $this->requestStack = $requestStack;
        $this->session = $requestStack->getSession();
        $this->entityManager = $entityManager;
    }





    public function get() 
    {
        return $this->session->get('cart');
        
    }


    public function add($id) 
    {
        $cart = $this->session->get('cart');
        
        if (!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        return $this->session->set('cart', $cart);
    }

    public function subtract($id) 
    {
        $cart = $this->session->get('cart');
        
        if ($cart[$id] > 1){
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    public function removeItem($id) 
    {
        $cart = $this->session->get('cart');

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function delete() 
    {
        return $this->session->remove('cart');
    }

    public function getFull() 
    {

        $cartDetails = [];
        if(!empty($this->get())){
            foreach($this->get() as $id => $quantity) {
                $cartDetails[] = [
                    'product' => $this->entityManager->getRepository(Product::class)->findOneBy(array('id' => $id)),
                    'quantity' => $quantity
                ];
            }
        }

        return $cartDetails;
       
    }
}