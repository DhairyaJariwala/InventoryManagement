<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller{
    /**
     * @Route("/product",name="product")
     */
    public function index(Request $request){
        return new Response ("<marquee>Hello Dhairya</marquee>");
    }
}
