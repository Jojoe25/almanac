<?php

namespace App\Controller;

use App\Entity\Walkthrough;
use App\Form\WalkthroughType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WalkthroughController extends AbstractController
{
    /**
     * @Route("/walkthrough/create", name="walkthrough_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $walkthrough = new Walkthrough();
        $walkthroughForm = $this->createForm(WalkthroughType::class, $walkthrough);

        $walkthroughForm->handleRequest($request);

        // Si le formulaire a été soumis et est valide, on enregistre le jeu dans la base de données.
        if ($walkthroughForm->isSubmitted() && $walkthroughForm->isValid()){
            $entityManager->persist($walkthrough);
            $entityManager->flush();

            // On ajoute un message flash de succès pour indiquer que le nouveau jeu a été ajouté.
            $this->addFlash('success', 'New Soluce added! Goodjob!! Lets PLAY!! ;-) ');

            // Récupérer l'ID du jeu associé au guide
            $gameId = $walkthrough->getGame()->getId();

            // Rediriger vers la page "walk" du même jeu
            return $this->redirectToRoute('games_walk', ['id' => $gameId]);
        }

        return $this->render('walkthrough/create.html.twig', [
            'walkthroughForm' => $walkthroughForm->createView()
        ]);
    }
}