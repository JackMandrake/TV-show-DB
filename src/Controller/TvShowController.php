<?php

namespace App\Controller;

use App\Entity\TvShow;
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
    public function add()
    {
        $tvShow = new TvShow();
        $tvShow->setTitle("The Mandalorian");

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($tvShow);
        $manager->flush();

        return $this->render('tv_show/add.html.twig');
    }
}
