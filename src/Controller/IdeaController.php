<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends AbstractController
{
    /**
     * @Route("/idea", name="idea")
     */
    public function index(): Response
    {
        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
        ]);
    }
}
