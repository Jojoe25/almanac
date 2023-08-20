<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function usersList(UserRepository $user)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $user->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(int $id, UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Vérifiez si l'utilisateur a le rôle "ADMIN"
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur a le rôle "ADMIN", ne permettez pas la modification du rôle
            $form = $this->createForm(EditUserType::class, $user, ['disable_admin_role' => true]);
        } else {
            // Sinon, permettez la modification normale
            $form = $this->createForm(EditUserType::class, $user);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On ajoute un message flash de succès pour indiquer que l'utilisateur a été modifié.
            $this->addFlash('success', 'Utilisateur modifié avec succès ');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
