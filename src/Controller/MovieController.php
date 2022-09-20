<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/movies', name: 'app_movies_index')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movies/{id}', name: 'app_movies_show', requirements: ['id' => '\d+'])]
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }
}
