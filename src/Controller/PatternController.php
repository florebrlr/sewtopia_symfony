<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PatternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/patterns', name: 'pattern_')]
class PatternController extends AbstractController
{
    //route de la liste de tous les patrons
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(PatternRepository $patternRepository): Response
    {
// récupère les patron publiés, du plus récent au plus ancien
        $patterns = $patternRepository->findBy(['isProduced' => true], ['dateProduced' => 'DESC']);
        return $this->render('pattern/list.html.twig', ["patterns" => $patterns]);
    }

    //route d'un patron
    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id, PatternRepository $patternRepository): Response
    {
// récupère ce patron en fonction de l'id présent dans l'URL
        $pattern = $patternRepository->find($id);
// s'il n'existe pas en bdd, on déclenche une erreur 404
        if (!$pattern){
            throw $this->createNotFoundException('This pattern do not exists! Sorry!');
        }
        return $this->render('pattern/detail.html.twig', [
            "pattern" => $pattern
        ]);
    }
}
