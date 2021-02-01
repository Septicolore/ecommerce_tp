<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteProductController extends AbstractController
{
    /**
     * @Route("/delete/product", name="delete_product")
     */
    public function index(): Response
    {
        return $this->render('delete_product/index.html.twig', [
            'controller_name' => 'DeleteProductController',
        ]);
    }
}
