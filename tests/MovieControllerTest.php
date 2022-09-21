<?php

namespace App\Tests;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public static function setupBeforeClass(): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $movieRepository = $entityManager->getRepository(Movie::class);
        $genreRepository = $entityManager->getRepository(Genre::class);

        $genreAction = (new Genre())
            ->setName('Action')
        ;

        $genreRepository->add($genreAction);

        $genreSuperHeros = (new Genre())
            ->setName('Super héros')
        ;
        $genreRepository->add($genreSuperHeros);

        $movie = (new Movie())
            ->setName('The Godfather')
            ->setDescription("Un film qui raconte la vie d'un jeune garçon élevé par un père mafieux et qui a voulu suivre un autre chemin")
            ->setYear(new \DateTime('2001-01-01'))
            ->setGenre($genreAction)
        ;
        $movieRepository->add($movie);


        $movie = (new Movie())
            ->setName('Black panther')
            ->setDescription("Un film incroyable de Marvel Studio qui met en scène un héro incroyable")
            ->setYear((new \DateTime('2013-01-01')))
            ->setGenre($genreAction)
        ;
        $movieRepository->add($movie);

        $movie = (new Movie())
            ->setName('The Lord of the Rings')
            ->setDescription("Le seigneur des anneaux")
            ->setYear(new \DateTime('2000-01-01'))
            ->setGenre($genreSuperHeros)
        ;
        $movieRepository->add($movie, true);

        self:self::ensureKernelShutdown();
    }

    public function testItShowAMovie(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies/2');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Black panther', $client->getResponse()->getContent());
        $this->assertStringContainsString('Un film incroyable de Marvel Studio qui met en scène un héro incroyable', $client->getResponse()->getContent());
        $this->assertStringContainsString('2013', $client->getResponse()->getContent());
    }

    public function testItThrows404ErrorWhenMovieNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies/123');

        $this->assertResponseStatusCodeSame(404);
    }
}
