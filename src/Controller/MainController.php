<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route('/about-me', name: 'main_about_me', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('main/about_me.html.twig');
    }

    #[Route('/calculator', name: 'main_calculator', methods: ['GET', 'POST'])]
    public function calculator(): Response
    {
        return $this->render('main/calculator.html.twig');
    }
}
