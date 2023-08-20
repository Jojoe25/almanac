<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\PropertySearch;
use App\Form\GameType;
use App\Form\PropertySearchType;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(GameRepository $gameRepository, Request $request): Response
    {
        $games = $gameRepository->findBestGames();

        $search = new PropertySearch();

        $searchForm = $this->createForm(PropertySearchType::class, $search);

        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {

            $games = $gameRepository->filtre($search);

        } else {

            $games = $gameRepository->findBestGames();;

        }
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
     * @Route("walk/{id}", name="walk")
     */
    public function walk(int $id, GameRepository $gameRepository): Response
    {
        // On récupère un jeu en fonction de son identifiant (id) depuis le référentiel (repository) des jeux.
        $game = $gameRepository->find($id);

        return $this->render('games/walk.html.twig', [
            "game" => $game
        ]);
    }
    /*  private function generateUniqueFileName(): string
      {
          return md5(uniqid());
      }*/
    /**
     * @Route("create", name="create")
     */
    public function addGame(Request $request)
    {
        $game = new Game();
        $game->setDateCreated(new \DateTime());

        $gameform = $this->createForm(GameType::class, $game);
        $gameform->handleRequest($request);

        if ($gameform->isSubmitted() && $gameform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $backdropFile = $gameform->get('backdrop')->getData();
            if ($backdropFile) {
                // Generate a unique name for the file
                $backdropFileName = md5(uniqid()) . '.' . $backdropFile->guessExtension();

                // Move the file to the desired location
                $backdropFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/img/backdrops',
                    $backdropFileName
                );

                // Set the backdrop property to the filename
                $game->setBackdrop($backdropFileName);
            }
            $posterFile = $gameform->get('poster')->getData();
            if ($posterFile) {
                $posterFileName = md5(uniqid()) . '.' . $posterFile->guessExtension();

                // Move the file to the desired location
                $posterFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/img/posters/games',
                    $posterFileName);

                $game->setPoster($posterFileName);
            }

            // Set other properties from the form
            // ...

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            // On ajoute un message flash de succès pour indiquer que le nouveau jeu a été ajouté.
            $this->addFlash('success', 'New Game added! Goodjob!! Lets PLAY!! ;-) ');

            return $this->redirectToRoute('games_details', ['id' => $game->getId()]);
        }

        return $this->render('games/create.html.twig', [
            'gameForm' => $gameform->createView()]);
    }




    /*  private function uploadFile($file)
      {
          $fileName = uniqid().'.'.$file->guessExtension();

          try {
              $file->move(
                  $this->getParameter('your_upload_directory'), // Change this to the actual upload directory
                  $fileName
              );
          } catch (FileException $e) {
              // Handle the exception if needed
          }

          return $fileName;
      }*/
}