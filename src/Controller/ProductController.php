<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     *  @Route("/product/{slug}_{id}", name="product")
     */
    public function index(Product $product): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'product' =>$product
        ]);
    }
}
