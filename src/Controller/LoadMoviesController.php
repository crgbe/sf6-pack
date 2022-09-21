<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoadMoviesController extends AbstractController
{
    #[Route('/load/movies', name: 'app_load_movies')]
    public function index(MovieRepository $movieRepository, GenreRepository $genreRepository): Response
    {
        return new Response('OK');
    }
}
