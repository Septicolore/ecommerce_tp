<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request, ProductRepository $Product): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);

        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );


        //__________________________FIND LAST ID_______________________
        $lastProduct = $Product->FindLastId();
        dump($lastProduct);
        //________________________
        $lastProduct = $lastProduct[0];
        dump($lastProduct);     //________________________________________________________________________


        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'pagination' => $pagination,
            'LastProduct' => $lastProduct
        ]);
    }
}







