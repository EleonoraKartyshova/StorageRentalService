<?php
/**
 * Created by PhpStorm.
 * User: eleonora
 * Date: 28.02.19
 * Time: 19:39
 */

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\StorageVolume;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTime;

class StorageCountManager extends AbstractController
{
    public function incrementStorageCount()
    {
        $dateTo = new \DateTime('- 1 days');

        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findBy([
                'dateTo' => $dateTo,
            ]);

        foreach ($reservations as $reservation) {
            $storageVolume = $this->getDoctrine()
                ->getRepository(StorageVolume::class)
                ->findOneBy([
                    'id' => $reservation->getStorageVolumeId(),
                ]);

            $storageVolumeCountForEdit = $storageVolume->getCount();
            $storageVolumeCountForEdit++;
            $storageVolume->setCount($storageVolumeCountForEdit);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($storageVolume);
            $entityManager->flush();
        }
    }
}

