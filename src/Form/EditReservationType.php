<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\StorageType;
use App\Entity\StorageVolume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class EditReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom', DateType::class)
            ->add('dateTo', DateType::class)
            ->add('details', TextareaType::class, ['required' => true])
            ->add('hasDelivery', ChoiceType::class, [
                'choices'  => [
                    'I will pick it up' => false,
                    'I need a delivery' => true,
                ],
            ])
            ->add('storageTypeId', EntityType::class, [
                'class' => StorageType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('type')
                        ->where('type.isActive = 1');
                },
            ])
            ->add('storageVolumeId', EntityType::class, [
                'class' => StorageVolume::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('volume')
                        ->where('volume.count > 0');
                },
                'choice_attr' => function (StorageVolume $volume) {
                    return array('class' => strval($volume->getStorageTypeId()->getId()));
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
