<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class UpdateUserRoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */

    public function list(UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->findAll();

        return $this->render('admin/role.html.twig', [
            "users" => $user,

        ]);
    }

    /**
     * @Route("/change-role/{id}", "change_role")
     */
    public function changeRole(int $id, UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->find($id);
        $users = $userRepository->findAll();

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createFormBuilder()
            ->add('newRole', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Editor' => 'ROLE_EDITOR',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newRoles = $data['newRole'];

            $userRepository->changeUserRole($user, $newRoles);

            return $this->redirectToRoute('admin_role');
        }

        return $this->render('admin/role.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }

}