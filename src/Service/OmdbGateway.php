<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbGateway
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getPosterByMovie(Movie $movie): ?string
    {
        $response = $this->httpClient->request('GET', sprintf(
            'https://www.omdbapi.com/?apikey=%s&t=%s',
            'e0ded5e2',
            $movie->getName())
        );

        $responseToArray = $response->toArray();

        return array_key_exists('Poster', $responseToArray) ? $responseToArray['Poster'] : null;
    }
}