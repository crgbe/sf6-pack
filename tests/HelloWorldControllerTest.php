<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldControllerTest extends WebTestCase
{
    public function testHelloWithANameParameterReturnsHelloThatName(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello/Adrien');
        $content = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertSame('Hello Adrien !', $content);
    }

    public function testHelloWithNothingReturnsHelloWorld(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello');
        $content = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertSame('Hello World !', $content);
    }
}
