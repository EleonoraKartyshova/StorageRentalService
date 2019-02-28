<?php

namespace App\Form;

use App\Entity\Goods;
use App\Entity\GoodsProperty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GoodsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('goodsPropertyId', EntityType::class, [
                'class' => GoodsProperty::class,
                'required' => true
            ])
            ->add('details', TextareaType::class, ['required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Goods::class,
        ]);
    }
}
