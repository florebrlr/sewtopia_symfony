<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CalculatorFormType;
use App\Services\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function calculator(Request $request, Calculator $calculator): Response
    {
        $calculatorForm = $this->createForm(CalculatorFormType::class);
        $calculatorForm->handleRequest($request);
        $resultat = 0;

        if ($calculatorForm->isSubmitted() && $calculatorForm->isValid()) {
            $data = $calculatorForm->getData();
            $tourDeTaille = $data['tour_de_taille'];
            $longueurJupe = $data['longueur_jupe'];

            // Calculer la quantité de tissu nécessaire
            $resultat =$calculator -> CalculateCircleSkirt((float)$tourDeTaille, (float)$longueurJupe);
        }

        // Rendre la vue avec le formulaire et le résultat du calcul
        return $this->render('main/calculator.html.twig', [
            'calculatorForm' => $calculatorForm,
            'resultat' => $resultat,
        ]);
    }
}

