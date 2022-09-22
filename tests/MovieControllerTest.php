<?php

namespace App\Tests;

use App\DataFixtures\MovieFixtures;
use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $fixtureExecutor = new ORMExecutor(
            $entityManager,
            new ORMPurger($entityManager)
        );

        $fixtureExecutor->execute([new MovieFixtures()]);

        self:self::ensureKernelShutdown();
    }

    public function testItShowAMovie(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies/5');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Jurassic Park', $client->getResponse()->getContent());
        $this->assertStringContainsString('Le film de dinozaures', $client->getResponse()->getContent());
        $this->assertStringContainsString('1999', $client->getResponse()->getContent());
    }

    public function testItThrows404ErrorWhenMovieNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies/123');

        $this->assertResponseStatusCodeSame(404);
    }
}
