<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pattern;
use App\Form\PatternType;
use App\Repository\PatternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patterns', name: 'pattern_')]
class PatternController extends AbstractController
{
    //route de la liste de tous les patrons
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(PatternRepository $patternRepository): Response
    {
        //récupère tous les patrons
        $patterns = $patternRepository->findAll();
        return $this->render('pattern/list.html.twig', ["patterns" => $patterns]);
    }

    //route d'un patron
    #[Route('/{id}', name: 'detail',requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function detail(int $id, PatternRepository $patternRepository): Response
    {
        $pattern = $patternRepository->find($id);
        if (!$pattern) {
            throw $this->createNotFoundException("Ce patron n\'existe pas !");
        }
        return $this->render('pattern/detail.html.twig', [
            "pattern" => $pattern
        ]);
    }

    //route pour créer un nouveau patron
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pattern = new Pattern();
        $patternForm = $this->createForm(PatternType::class, $pattern);
        $patternForm->handleRequest($request);
        if ($patternForm->isSubmitted() && $patternForm->isValid()) {
            $pattern->setIsPrinted(true);
            $em->persist($pattern);
            $em->flush();
            $this->addFlash('success', 'Le patron a été créé!');
            return $this->redirectToRoute('pattern_detail', ['id' => $pattern->getId()]);
        }
        // affiche le formulaire
        return $this->render('pattern/create.html.twig', [
            'patternForm' => $patternForm->createView()
        ]);
    }

    //route pour modifier un patron
    #[Route('/{id}/update', name: 'update', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function update(int $id, PatternRepository $patternRepository, Request $request,
                           EntityManagerInterface $em): Response
    {
        $pattern = $patternRepository->find($id);
        if (!$pattern) {
            throw $this->createNotFoundException('Ce patron n\'existe pas!');
        }
        $patternForm = $this->createForm(PatternType::class, $pattern);
        $patternForm->handleRequest($request);
        if ($patternForm->isSubmitted() && $patternForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Ce patron a été mis à jour!');
            return $this->redirectToRoute('pattern_detail', ['id' => $pattern->getId()]);
        }
        return $this->render('pattern/create.html.twig', [
            'patternForm' => $patternForm->createView()
        ]);
    }

    //route pour supprimer un patron
    #[Route('/{id}/delete', name: 'delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function delete(int $id, PatternRepository $patternRepository, Request $request,
                           EntityManagerInterface $em): Response
    {
        $pattern = $patternRepository->find($id);
        if (!$pattern) {
            throw $this->createNotFoundException('Ce patron n\'existe pas!');
        }
        if ($this->isCsrfTokenValid('delete' . $id, $request->query->get('token'))) {
            $em->remove($pattern);
            $em->flush();
            $this->addFlash('success', 'Ce patron a bien été supprimé!');
        } else {
            $this->addFlash('danger', 'Suppression du patron impossible!');
        }
        return $this->redirectToRoute('pattern_list');
    }
}
