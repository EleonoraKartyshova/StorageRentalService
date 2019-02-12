<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminUserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/users", name="admin_users")
     */
    public function getAllUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('page/admin_users_list.html.twig', [
            'admin' => 'active',
            'users' => $users
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/deactivate_user/{id}", name="admin_deactivate_user", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function deactivateUser($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'id' => $id,
            ]);
        if ($request->request->get('deactivateUser')) {
            $user->setIsActive('0');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_users');
        }
        return $this->render('page/admin_deactivate_user.html.twig', [
                'admin' => 'active',
                'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/activate_user/{id}", name="admin_activate_user", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function activateUser($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'id' => $id,
            ]);
        if ($request->request->get('activateUser')) {
            $user->setIsActive('1');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_users');
        }
        return $this->render('page/admin_activate_user.html.twig', [
            'admin' => 'active',
            'user' => $user
        ]);
    }
}
