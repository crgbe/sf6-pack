<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello/{name}', name: 'app_hello_world')]
    public function index(Request $request, $name): Response
    {
//        $name = $request->query->get('name', 'Le monde');

        return new Response('Hello ' . $name . ' !');

//        return $this->render('hello_world/index.html.twig', [
//            'controller_name' => 'HelloWorldController',
//        ]);
    }
}
