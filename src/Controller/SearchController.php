<?php

namespace App\Controller;


use App\Entity\PropertySearch;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/property", name="app_property")
     */

    public function property(
        GameRepository $gameRepository,
        Request $request
    ): Response
    {
        $searchForm = new propertysearch();

        return $this->render('games/list.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}