<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/games", name="games_")
 */
class GameController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(GameRepository $gameRepository): Response
    {
        // findBy ici va permettre de trier par rapport a un findAll, en lui passant un tableau vide, cela va faire la même chose que le findAll, on limite le nombre de résultat a 30.
        $games = $gameRepository->findBy([], ['vote' => 'DESC'], 30 );

        return $this->render('games/list.html.twig', [
            "games" => $games
        ]);
    }

    /**
     * @Route("details/{id}", name="details")
     */
    public function details(int $id, GameRepository $gameRepository): Response
    {
        $game = $gameRepository->find($id);

        return $this->render('games/details.html.twig', [
            "game" => $game
        ]);
    }

    /**
     * @Route("create", name="create")
     */
    public function create(): Response
    {
        // todo aller chercher le jeux en bdd
        return $this->render('games/create.html.twig', [
        ]);
    }

}
