<?php

namespace App\Form;

use App\Entity\OfferVariation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferVariationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('priceVariation')
            ->add('duration')
            ->add('price')
            ->add('currentVat')
            ->add('capacity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OfferVariation::class,
        ]);
    }
}
