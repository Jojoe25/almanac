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
     * @Route("/walktrough/create", name="walktrough_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $walkthrough = new Walkthrough();
        $walkthroughForm = $this->createForm(WalkthroughType::class, $walkthrough);

        $walkthroughForm->handleRequest($request);

        if ($walkthroughForm->isSubmitted() && $walkthroughForm->isValid()){
            $entityManager->persist($walkthrough);
            $entityManager->flush();
            // On ajoute un message flash de succès pour indiquer que le nouveau jeu a été ajouté.
            $this->addFlash('success', 'New Soluce added! Goodjob!! Lets PLAY!! ;-) ');
        }

        return $this->render('walktrough/create.html.twig', [
            'walkthroughForm' => $walkthroughForm->createView()
        ]);
    }
}