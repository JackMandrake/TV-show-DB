<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category_view", requirements={"id"="\d+"})
     */
    public function view(Category $category)
    {
        return $this->render('category/view.html.twig', ["category" => $category]);
    }

    /**
     * @Route("/category", name="category_list")
     */
    public function categoryList()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        
        return $this->render(
            'category/list.html.twig',
            [
                "categories" => $categories
            ]
        );
    }

}
