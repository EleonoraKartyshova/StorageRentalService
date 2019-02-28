<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\StorageVolume;
use App\Form\EditStorageVolumeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminStorageVolumeController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/storage_volumes", name="admin_storage_volumes")
     */
    public function getAllStorageVolumes()
    {
        $storage_volumes = $this->getDoctrine()
            ->getRepository(StorageVolume::class)
            ->findAll();

        return $this->render('page/admin_storage_volumes.html.twig', [
            'admin' => 'active',
            'storage_volumes' => $storage_volumes
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/edit_storage_volume/{id}", name="admin_edit_storage_volume", requirements={"id"="\d+"}, options={"expose": true})
     */
    public function editStorageVolume($id, Request $request)
    {
        $storage_volume = $this->getDoctrine()
            ->getRepository(StorageVolume::class)
            ->findOneBy([
                'id' => $id,
            ]);

        $form = $this->createForm(EditStorageVolumeType::class, $storage_volume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $volume = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($volume);
            $entityManager->flush();

            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('admin_storage_volumes');
        }
        return $this->render('page/admin_edit_storage_volume.html.twig', [
            'admin' => 'active',
            'edit_storage_volume_form' => $form->createView(),
            'storage_volume' => $storage_volume,
        ]);
    }
}
