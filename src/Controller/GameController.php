<?php

namespace App\Controller;

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
    public function list(): Response
    {
        // todo aller chercher les jeux en bdd

        return $this->render('games/list.html.twig', [

        ]);
    }

    /**
     * @Route("details/{id}", name="details")
     */
    public function details(int $id): Response
    {
        // todo aller chercher le jeux en bdd
        return $this->render('games/details.html.twig', [
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
