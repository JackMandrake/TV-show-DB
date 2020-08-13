<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{
    /**
     * @Route("/episode", name="episode")
     */
    public function index()
    {
        return $this->render('episode/index.html.twig', [
            'controller_name' => 'EpisodeController',
        ]);
    }
}
