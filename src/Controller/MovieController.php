<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Service\OmdbGateway;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private OmdbGateway $omdbGateway;

    public function __construct(OmdbGateway $omdbGateway)
    {
        $this->omdbGateway = $omdbGateway;
    }

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

        $moviePosterLink = $this->omdbGateway->getPosterByMovie($movie) ?? 'https://img1.picmix.com/output/stamp/normal/6/4/0/4/2084046_94f55.png';

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'moviePosterLink' => $moviePosterLink
        ]);
    }

    #[Route('/movies/new', name: 'app_movies_new')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, MovieRepository $movieRepository): Response
    {
        $newForm = $this->createForm(MovieType::class);

        $newForm->handleRequest($request);

        if($newForm->isSubmitted() && $newForm->isValid()){
            /** @var Movie $movie */
            $movie = $newForm->getData();
            $movie->setCreatedBy($this->getUser());
            $movieRepository->add($movie, true);

            $this->addFlash('success', 'The movie "'. $movie->getName() .'" has been created' );

            return $this->redirectToRoute('app_movies_index');
        }

        return $this->render('movie/new.html.twig', [
            'newForm' => $newForm->createView()
        ]);
    }

    #[Route('/movies/delete/{id}', name: 'app_movies_delete', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('can_delete', 'movie')]
    public function delete(Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($movie);
        $entityManager->flush();

        return $this->redirectToRoute('app_movies_index');
    }
}
