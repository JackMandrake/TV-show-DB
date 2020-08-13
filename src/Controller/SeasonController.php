<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SeasonController extends AbstractController
{
    /**
     * @Route("/season", name="season")
     */
    public function index()
    {
        return $this->render('season/index.html.twig', [
            'controller_name' => 'SeasonController',
        ]);
    }
}
