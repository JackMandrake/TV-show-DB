<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{

    /**
     * @Route("/categories", name="category_list")
     */
    public function list()
    {
        /** @var CategoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAllOrderedByLabel();

        return $this->render('category/list.html.twig', ["categories" => $categories]);
    }


    /**
     * @Route("/category/{id}", name="category_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var CategoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneWithTvShows($id);
        
        return $this->render('category/view.html.twig', ["category" => $category]);
    }

    /**
     * @Route("/category/add", name="category_add")
     */
    public function add(Request $request)
    {
        // je crée un objet
        $category = new Category();

        // je demande a créer un formulaire grace à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(CategoryType::class, $category);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $category

        // Si des données ont été soumises dans le formulaire
        if($form->isSubmitted() && $form->isValid()) {
            // si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash("success", "La category a bien été ajoutée");
            return $this->redirectToRoute('category_list');
        }

        // on envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'category/add.html.twig',
            [
                "categoryForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/category/{id}/update", name="category_update", requirements={"id"="\d+"})
     */
    public function update(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager(); 
            $manager->flush();
            
            $this->addFlash("success", "La catégorie a bien été mise à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('category_view', ["id" => $category->getId()]);
        }

        return $this->render(
            'category/update.html.twig',
            [
                "categoryForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/category/{id}/delete", name="category_delete")
     */
    public function delete(Category $category, Request $request)
    {
       
        // je demande a créer un formulaire grace à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(CategoryType::class, $category);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $category

        // Si des données ont été soumises dans le formulaire
        if($form->isSubmitted() && $form->isValid()) {
            // si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash("success", "La category a bien été supprimé");
            return $this->redirectToRoute('category_list');
        }

        // on envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'category/delete.html.twig',
            [
                "categoryForm" => $form->createView()
            ]
        );
    }

}
