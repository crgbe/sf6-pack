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
        $genreAction = (new Genre())
            ->setName('Action')
        ;

        $genreRepository->add($genreAction);

        $genreSuperHeros = (new Genre())
            ->setName('Super héros')
        ;
        $genreRepository->add($genreSuperHeros);

        $movie = (new Movie())
            ->setName('Godfather')
            ->setDescription("Un film qui raconte la vie d'un jeune garçon élevé par un père mafieux et qui a voulu suivre un autre chemin")
            ->setYear(new \DateTime('2001-01-01'))
            ->setGenre($genreAction)
        ;
        $movieRepository->add($movie);


        $movie = (new Movie())
            ->setName('Blackpanther')
            ->setDescription("Un film incroyable de Marvel Studio qui met en scène un héro incroyable")
            ->setYear((new \DateTime('2013-01-01')))
            ->setGenre($genreAction)
        ;
        $movieRepository->add($movie);

        $movie = (new Movie())
            ->setName('Lord of rings')
            ->setDescription("Le seigneur des anneaux")
            ->setYear(new \DateTime('2000-01-01'))
            ->setGenre($genreSuperHeros)
        ;
        $movieRepository->add($movie, true);

        return new Response('OK');
    }
}
