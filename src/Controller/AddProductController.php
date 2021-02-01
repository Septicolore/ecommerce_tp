<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddProductController extends AbstractController
{
    /**
     * @Route("/add/product", name="add_product")
     */
    public function index(): Response
    {
        //on creer le formulaire a partir de addproductformtype
        $form = $this->createForm(AddProductFormType::class);

        return $this->render('add_product/index.html.twig', [
            //permet d'afficher le formulaire
            'AddProductFormType' =>$form->createView(),
        ]);
    }

    public function create(Request $request): Response
    {
        // On crée un objet qui est une instance de notre entité

        $product = new Product();

        //On crée le formulaire a partir de AddProductFormType (dans le dossier form)
        //symfony rempli l'objet $OneProduct avec les données du formulaire
        // grâce à la request
        $form = $this->createForm(AddProductFormType::class, $product);

        //Permet de lié le formulaire à la requete (pour récuperer le $_POST)
        $form->handleRequest($request);

        //On vérifie que le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Ici on ajoute l'annonce de la base
            //dump($form->getData()); //Permet de faire un dump
            // et vérifie si le formulaire a bien transmis ce que l'on veut
            //$Product est la meme chose que getData car on l'a rajouter dans le createform
            dump($product);

            //upload image
            /** @var UploadedFile $image */
            $image = $form->get('img')->getData();
            if ($image) {
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($this->getParameter('upload_directory'));
                $product->setImg($filename);
            }else {
                $product->setImg('default.jpg');
            }




            //On ajoute l'objet dans la BDD
            //On récupere le service doctrine qui permet de gérer la base de données
            $entityManager = $this->getDoctrine()->getManager();
            //On doit mettre l'objet en attente
            $entityManager->persist($product);
            //On exécute la requete
            $entityManager->flush();


            //___Redirection et message de succes__
            $this->addFlash('success', 'votre produit ' . $Product->getName() . ' a bien été ajouté');
            return $this->redirecttoRoute('products');


        }

        return $this->render('add_product/index.html.twig', [
            //permet d'afficher le formulaire
            'AddProductFormType' => $form->createView(),
        ]);
    }
}


