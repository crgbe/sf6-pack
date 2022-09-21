<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldControllerTest extends WebTestCase
{
    public function testHelloWithANameParameterReturnsHelloThatName(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello/Adrien');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello Adrien !');
    }

    public function testHelloWithNothingReturnsHelloWorld(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello World !');
    }
}
