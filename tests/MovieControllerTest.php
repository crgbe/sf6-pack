<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public function testItShowAMovie(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies/1');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Blackpanther', $client->getResponse()->getContent());
        $this->assertStringContainsString('Un film incroyable de Marvel Studio qui met en sc\u00e8ne un h\u00e9ro incroyable', $client->getResponse()->getContent());
        $this->assertStringContainsString('2013', $client->getResponse()->getContent());
    }

    public function testItThrows404ErrorWhenMovieNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies/123');

        $this->assertResponseStatusCodeSame(404);
    }
}
