<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
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

    #[Route('/movies/new', name: 'app_movies_new')]
    public function new(Request $request, MovieRepository $movieRepository): Response
    {
        $newForm = $this->createForm(MovieType::class);

        $newForm->handleRequest($request);

        if($newForm->isSubmitted() && $newForm->isValid()){
            $movie = $newForm->getData();
            $movieRepository->add($movie, true);

            $this->addFlash('success', 'The movie "'. $movie->getName() .'" has been created' );

            return $this->redirectToRoute('app_movies_index');
        }

        return $this->render('movie/new.html.twig', [
            'newForm' => $newForm->createView()
        ]);
    }

}
