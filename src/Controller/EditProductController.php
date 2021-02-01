<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditProductController extends AbstractController
{
    /**
     * @Route("/edit/product/{id}", name="edit_product")
     */
    public function edit(Request $request, Product $Product): Response
    {
        //On crée le formulaire a partir de AddProductFormType (dans le dossier form)
        //symfony rempli l'objet $OneProduct avec les données du formulaire
        // grâce à la request
        $form = $this->createForm(AddProductFormType::class, $Product);

        //Permet de lié le formulaire à la requete (pour récuperer le $_POST)
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            // Upload
            // On récupère la valeur du champ

            $image = $form->get('img')->getData();
            if($image){// Si on upload une image dans l'annnonce
                // On doit vérifier si une ancienne image est présente pour la supprimer
                // On fera attention de ne pas supprimer default.jpg et les fixtures

                // On est donc sûr de supprimer uniquement les images des utilisateurs
                $defaultImages = ['default.png', 'fixtures/1.jpg',  'fixtures/2.jpg',  'fixtures/3.jpg',
                    'fixtures/4.jpg', 'fixtures/5.jpg',];

                if($Product->getImg() && !in_array($Product->getImg(), $defaultImages)) {
                    // FileSystem permet de manipuler les fichiers
                    $fs = new Filesystem();
                    // On supprime l'ancienne image
                    $fs->remove($this->getParameter('upload_directory').'/'.$Product->getImg());
                }
                $filename = uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $filename);
                $Product->setImg($filename);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirecttoRoute('products');
        }


        return $this->render('edit_product/index.html.twig', [
            'AddProductFormType' => $form->createView(),
            'Product' => $Product,
        ]);
    }
}