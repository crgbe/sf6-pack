<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genreAction = (new Genre())
            ->setName('Action')
        ;

        $manager->persist($genreAction);

        $genreSuperHeros = (new Genre())
            ->setName('Super héros')
        ;
        $manager->persist($genreSuperHeros);

        $movie = (new Movie())
            ->setName('The Godfather')
            ->setDescription("Un film qui raconte la vie d'un jeune garçon élevé par un père mafieux et qui a voulu suivre un autre chemin")
            ->setYear(new \DateTime('2001-01-01'))
            ->setGenre($genreAction)
        ;
        $manager->persist($movie);


        $movie = (new Movie())
            ->setName('Black panther')
            ->setDescription("Un film incroyable de Marvel Studio qui met en scène un héro incroyable")
            ->setYear((new \DateTime('2013-01-01')))
            ->setGenre($genreAction)
        ;
        $manager->persist($movie);

        $movie = (new Movie())
            ->setName('The Lord of The Rings')
            ->setDescription("Le seigneur des anneaux")
            ->setYear(new \DateTime('2000-01-01'))
            ->setGenre($genreSuperHeros)
        ;
        $manager->persist($movie);

        $manager->flush();
    }
}
