<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\PropertySearch;
use App\Form\GameType;
use App\Form\PropertySearchType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/games", name="games_")
 */
class GameController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(GameRepository $gameRepository, Request $request): Response
    {
        $games = $gameRepository->findBestGames();

        $search = new PropertySearch();
        $searchForm = $this->createForm(PropertySearchType::class, $search);

        $searchForm->handleRequest($request);
        return $this->render('games/list.html.twig', [
            "games" => $games,
            "searchForm" => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("details/{id}", name="details")
     */
    public function details(int $id, GameRepository $gameRepository): Response
    {
        // On récupère un jeu en fonction de son identifiant (id) depuis le référentiel (repository) des jeux.
        $game = $gameRepository->find($id);

        return $this->render('games/details.html.twig', [
            "game" => $game
        ]);
    }


    /**
     * @Route("create", name="create")
     */
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        // On crée un nouvel objet "Game".
        $game = new Game();
        // On attribue directement la date de création du jeu (maintenant) car cela est absent du formulaire mais requis dans la base de données.
        $game->setDateCreated(new \DateTime());
        // On attribue une valeur par défaut pour le champ "backdrop" (arrière-plan) et "poster" du jeu. TODO: À modifier pour permettre l'ajout direct d'une image en upload.
        $game->setBackdrop(1);
        $game->setPoster(1);
        // On crée un formulaire pour le jeu en utilisant la classe de formulaire "GameType" et on le relie aux données de l'objet "Game" créé.
        $gameForm = $this->createForm(GameType::class, $game);
        // On traite la requête HTTP pour voir si le formulaire a été soumis.
        $gameForm->handleRequest($request);

        // Si le formulaire a été soumis et est valide, on enregistre le jeu dans la base de données.
        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            // On persiste l'objet "Game" pour qu'il soit géré par Doctrine.
            $entityManager->persist($game);
            // On exécute la requête pour enregistrer le jeu dans la base de données.
            $entityManager->flush();
            // On ajoute un message flash de succès pour indiquer que le nouveau jeu a été ajouté.
            $this->addFlash('success', 'New Game added! Goodjob!! Lets PLAY!! ;-) ');
            // On redirige l'utilisateur vers la page des détails du jeu nouvellement créé.
            return $this->redirectToRoute('games_details', ['id' => $game->getId()]);
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, on affiche le formulaire de création du jeu.
        return $this->render('games/create.html.twig', [
            'gameForm' => $gameForm->createView()
        ]);
    }
}