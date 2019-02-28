<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\StorageType;
use App\Form\EditStorageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminStorageTypeController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/storage_types", name="admin_storage_types")
     */
    public function getAllStorageTypes()
    {
        $storage_types = $this->getDoctrine()
            ->getRepository(StorageType::class)
            ->findAll();

        return $this->render('page/admin_storage_types.html.twig', [
            'admin' => 'active',
            'storage_types' => $storage_types
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/deactivate_storage_type/{id}", name="admin_deactivate_storage_type", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function deactivateStorageType($id, Request $request)
    {
        $storage_type = $this->getDoctrine()
            ->getRepository(StorageType::class)
            ->findOneBy([
                'id' => $id,
            ]);
        if ($request->request->get('deactivateStorageType')) {
            $storage_type->setIsActive('0');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_storage_types');
        }
        return $this->render('page/admin_deactivate_storage_type.html.twig', [
            'admin' => 'active',
            'storage_type' => $storage_type
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/activate_storage_type/{id}", name="admin_activate_storage_type", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function activateStorageType($id, Request $request)
    {
        $storage_type = $this->getDoctrine()
            ->getRepository(StorageType::class)
            ->findOneBy([
                'id' => $id,
            ]);
        if ($request->request->get('activateStorageType')) {
            $storage_type->setIsActive('1');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_storage_types');
        }
        return $this->render('page/admin_activate_storage_type.html.twig', [
            'admin' => 'active',
            'storage_type' => $storage_type
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/edit_storage_type/{id}", name="admin_edit_storage_type", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function editStorageType($id, Request $request)
    {
        $storage_type = $this->getDoctrine()
            ->getRepository(StorageType::class)
            ->findOneBy([
                'id' => $id,
            ]);

        $form = $this->createForm(EditStorageType::class, $storage_type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_storage_types');
        }
        return $this->render('page/admin_edit_storage_type.html.twig', [
            'admin' => 'active',
            'edit_storage_type_form' => $form->createView(),
            'storage_type' => $storage_type,
        ]);
    }
}
