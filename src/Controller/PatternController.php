<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/patterns', name: 'pattern_')]
class PatternController extends AbstractController
{
    //route de la liste des patrons
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('pattern/list.html.twig');
    }

    //route d'un patron
    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(): Response
    {
        return $this->render('pattern/detail.html.twig');
    }

}
