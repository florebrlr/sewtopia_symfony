<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pattern;
use App\Form\PatternType;
use App\Repository\PatternRepository;
use App\Services\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patterns', name: 'pattern_')]
class PatternController extends AbstractController
{
    //route de la liste de tous les patrons
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(PatternRepository $patternRepository, Request $request): Response
    {
        // Récupérer tous les patrons
        $patterns = $patternRepository->findAll();

        // Créer le formulaire de recherche
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        // Vérifier si le formulaire a été soumis et filtrer les résultats en fonction des données
        if ($form->isSubmitted() && $form->isValid()) {
            $searchData = $form;
            // Effectuer la recherche en fonction des critères dans SearchData
            $patterns = $patternRepository->findBySearchData($searchData)->getResult();
        }

        // Passer le formulaire et les patrons au template
        return $this->render('pattern/list.html.twig', [
            'patterns' => $patterns,
            'form' => $form->createView(), // Passer le formulaire au template
        ]);
    }


    //route d'un patron
    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
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
    public function create(Request $request, EntityManagerInterface $em, Uploader $uploader): Response
    {
        $pattern = new Pattern();
        $patternForm = $this->createForm(PatternType::class, $pattern);
        $patternForm->handleRequest($request);
        if ($patternForm->isSubmitted() && $patternForm->isValid() && $this->getUser()) {
            $image = $patternForm->get('image')->getData();
            $pattern->setUser($this->getUser());
            if ($image) {
                $pattern->setImage(
                    $uploader->save($image, $pattern->getTitle(), $this->getParameter('pattern_image_dir'))
                );
            }
            $em->persist($pattern);
            $em->flush();
            $this->addFlash('success', 'Le patron' . $pattern->getTitle() . ' a été créé!');
            return $this->redirectToRoute('pattern_detail', ['id' => $pattern->getId()]);
        }
        // affiche le formulaire
        return $this->render('pattern/create.html.twig', [
            'patternForm' => $patternForm->createView()
        ]);
    }

    //route pour modifier un patron
    #[Route('/{id}/update', name: 'update', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function update(
        int                    $id,
        PatternRepository      $patternRepository,
        Request                $request,
        EntityManagerInterface $em,
        Uploader               $uploader

    ): Response
    {
        $pattern = $patternRepository->find($id);

        if (!$pattern) {
            throw $this->createNotFoundException('Ce patron n\'existe pas!');
        }
        if ($pattern->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        } else {
            $patternForm = $this->createForm(PatternType::class, $pattern);
            $patternForm->handleRequest($request);
        }
        if ($patternForm->isSubmitted() && $patternForm->isValid()) {


            // ici si je rajoute une img, il faut qu'elle soit save
            if ($image) {
                $pattern->setImage(
                    $uploader->save($image, $pattern->getTitle(), $this->getParameter('pattern_image_dir'))
                );
            }
            $em->persist($pattern);
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
    public function delete(
        int                    $id,
        PatternRepository      $patternRepository,
        Request                $request,
        EntityManagerInterface $em
    ): Response
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

    #[Route('/favorites', name: 'favorites_list', methods: ['GET'])]
    public function favortiesList(PatternRepository $patternRepository): Response
    {
        //récupère tous les patrons
        $patterns = $patternRepository->findAll();
        return $this->render('pattern/favorites_list.html.twig', ["patterns" => $patterns]);
    }

// Route pour ajouter/enlever un patron des favoris via AJAX
    #[Route('/{id}/toggle_favorite', name: 'toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(
        int                    $id,
        PatternRepository      $patternRepository,
        EntityManagerInterface $em,
        Request                $request
    ): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            // Ajout d'une redirection ou d'un message flash si l'utilisateur n'est pas connecté
            return $this->json(['error' => 'Vous devez être connecté pour ajouter aux favoris.'], 400);
        }

        // Récupérer le patron
        $pattern = $patternRepository->find($id);
        if (!$pattern) {
            return new JsonResponse(['error' => 'Patron introuvable.'], 404);
        }

        // Vérifier si ce patron est déjà un favori
        if ($pattern->getFavoritedBy()->contains($user)) {
            // Si déjà favori, on l'enlève
            $pattern->removeFavoritedBy($user);
            $action = 'retiré';
        } else {
            // Sinon, on l'ajoute aux favoris
            $pattern->addFavoritedBy($user);
            $action = 'ajouté';
        }

        // Enregistrer les changements
        $em->persist($pattern);
        $em->flush();

        // Retourner une réponse JSON
        return new JsonResponse([
            'message' => "Patron " . $action . " des favoris.",
            'isFavorited' => $pattern->getFavoritedBy()->contains($user)
        ]);
    }
}
