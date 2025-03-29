<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CalculatorFormType;
use App\Services\Calculator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use http\Env\Request;
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

    #[Route('/convertisseur', name: 'main_converter', methods: ['GET', 'POST'])]
    public function converter(Request $request, Calculator $calculator): Response
    {
        $form = $this->createForm(CalculatorFormType::class);
        $form->handleRequest($request);
        $resultat = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $tourDeTaille = $data['tour_de_taille'];
            $longueurJupe = $data['longueur_jupe'];

            // Calculer la quantité de tissu nécessaire
            $resultat = $this->$calculator>CalculateCircleSkirt((float) $tourDeTaille, (float) $longueurJupe);
        }

        // Rendre la vue avec le formulaire et le résultat du calcul
        return $this->render('main/converter.html.twig', [
            'calculatorForm' => $form->createView(),
            'resultat' => $resultat,
        ]);
    }
}

