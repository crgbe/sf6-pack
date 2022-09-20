<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello/{name}', name: 'app_hello_world', requirements: ['name' => '[a-zA-Z]+'])]
    public function index(Request $request, string $name = 'World'): Response
    {
//        $name = $request->query->get('name', 'Le monde');

        return $this->render('hello_world/index.html.twig', [
            'name' => $name,
        ]);
    }
}
