<?php

namespace App\Controller;

use App\Entity\TvShow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TvShowController extends AbstractController
{
    /**
     * @Route("/tv-shows", name="tv_show_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(TvShow::class);
        $tvShows = $repository->findAll();
        
        return $this->render(
            'tv_show/list.html.twig',
            [
                "tvShows" => $tvShows
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
