<?php

namespace App\Controller;

use App\Entity\TvShow;
use App\Form\TvShowType;
use App\Repository\TvShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TvShowController extends AbstractController
{
    /**
     * @Route("/tv-shows", name="tv_show_list")
     */
    public function list(Request $request)
    {
        $search = $request->query->get('search');

        /** @var TvShowRepository $repository */
        $repository = $this->getDoctrine()->getRepository(TvShow::class);
        $tvShows = $repository->findByTitle($search);
        
        return $this->render(
            'tv_show/list.html.twig',
            [
                "tvShows" => $tvShows
            ]
        );
    }

    /**
     * @Route("/tv-show/{id}", name="tv_show_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var TvShowRepository $repository */
        $repository = $this->getDoctrine()->getRepository(TvShow::class);
        $tvShow = $repository->findWithCollections($id);

        return $this->render(
            'tv_show/view.html.twig',
             [
                 "tvShow" => $tvShow
             ]
        );
    }
    
    /**
     * @Route("/tv-show/add", name="tv_show_add")
     */
    public function add(Request $request)
    {
        // je crée un objet
        $tvShow = new TvShow();

        // je demande a créer un formulaire grace à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(TvShowType::class, $tvShow);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $tvShow

        // Si des données ont été soumises dans le formulaire
        if($form->isSubmitted() && $form->isValid()) {
            // si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tvShow);
            $manager->flush();
            $this->addFlash("success", "La série a bien été ajoutée");
            return $this->redirectToRoute('tv_show_list');
        }

        // on envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'tv_show/add.html.twig',
            [
                "tvShowForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/tv-show/{id}/update", name="tv_show_update", requirements={"id"="\d+"})
     */
    public function update(TvShow $tvShow, Request $request)
    {
        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager(); 
            $manager->flush();
            
            $this->addFlash("success", "La série a bien été mise à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('tv_show_view', ["id" => $tvShow->getId()]);
        }

        return $this->render(
            'tv_show/update.html.twig',
            [
                "tvShowForm" => $form->createView()
            ]
        );
    }

}
