<?php

namespace App\Controller;

use App\Entity\TvShow;
use App\Entity\Character;
use App\Form\CharacterType;
use App\Form\CharacterDeleteType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CharacterController extends AbstractController
{
    /**
     * @Route("/characters", name="character_list")
     */
    public function list()
    {
        /** @var CharacterRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Character::class);
        $characters = $repository->findAllOrderedByName();

        return $this->render('character/list.html.twig', ["characters" => $characters]);
    }

    /**
    * @Route("/character/{id}", name="character_view", requirements={"id"="\d+"})
    */
    public function view($id)
    {
        /** @var CharacterRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Character::class);
        $character = $repository->findOneWithCharacter($id);
        
        return $this->render('character/view.html.twig', ["character" => $character]);
    }

    /**
     * @Route("/character/add", name="character_add")
     */
    public function add(Request $request)
    {
        // je crée un objet
        $character = new Character();

        // je demande a créer un formulaire grace à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(CharacterType::class, $character);

        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);

        // automatiquement le formulaire a mis a jour mon objet $category

        // Si des données ont été soumises dans le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($character);
            $manager->flush();
            $this->addFlash("success", "Le personnage a bien été ajouté");
            return $this->redirectToRoute('character_list');
        }

        // on envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'character/add.html.twig',
            [
                "characterForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/character/{id}/update", name="character_update", requirements={"id"="\d+"})
     */
    public function update(Character $character, Request $request)
    {
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            
            $this->addFlash("success", "Le personnage a bien été mis à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('character_view', ["id" => $character->getId()]);
        }

        return $this->render(
            'character/update.html.twig',
            [
                "characterForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/character/{id}/delete", name="character_delete")
     */
    public function delete(Character $character, Request $request)
    {
       
        // je demande a créer un formulaire grace à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(CharacterDeleteType::class, $character);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $category
        // Si des données ont été soumises dans le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($character);
            $manager->flush();
            $this->addFlash("success", "Le personnage bien été supprimé");
            return $this->redirectToRoute('character_list');
        }
            // on envoi une representation simplifiée du formulaire dans la template
            return $this->render(
                'character/delete.html.twig',
                [
                "characterForm" => $form->createView()
            ]
            );
        }
    
}
