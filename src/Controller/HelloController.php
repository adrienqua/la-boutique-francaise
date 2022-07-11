<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HelloController extends AbstractController {

    /**
     * @Route("/hello/{message?World}", name="hi")
     */
    public function hello(Request $request, $message) {
        

        return new Response("Hello $message");
    }
}