<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response('Welcome to the marketplace!');
    }
}
