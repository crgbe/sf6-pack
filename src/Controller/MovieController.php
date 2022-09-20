<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    const MOVIES = [
        [
            'name' => 'Godfather',
            'description' => "Un film qui raconte la vie d'un jeune garçon élevé par un père mafieux et qui a voulu suivre un autre chemin",
            'year' => 2001
        ],
        [
            'name' => 'Blackpanther',
            'description' => 'Un film incroyable de Marvel Studio qui met en scène un héro incroyable',
            'year' => 2013
        ],
        [
            'name' => 'Lord of rings',
            'description' => "Le seigneur des anneaux",
            'year' => 2000
        ]
    ];

    #[Route('/movies/{id}', name: 'app_movies_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        if(!array_key_exists($id, self::MOVIES)){
            throw $this->createNotFoundException("Le film n'existe pas !");
        }

        $movie = self::MOVIES[$id];

        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }
}
