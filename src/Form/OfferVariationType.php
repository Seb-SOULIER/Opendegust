<?php

namespace App\Form;

use App\Entity\OfferVariation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferVariationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('priceVariation')
            ->add('duration')
            ->add('price', MoneyType::class)
            ->add('currentVat', PercentType::class)
            ->add('capacity')
            ->add('calendars', CollectionType::class, [
                'attr' => ['class' => 'calendars', 'data-items' => "[data-item-start-at]"],
                'entry_type' => CalendarType::class,
                'entry_options' => ['label' => false, 'attr' => ['class' => 'calendar']],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__name__'
            ])
            ->add('calendar', ButtonType::class, [
                'attr' => ['class' => 'btn btn-success', 'data-collection-holder-class' => 'calendars'],
                'label' => 'ajouter une période'
            ])
            ->add('delete', ButtonType::class, [
                'label' => 'Supprimer cette variation',
                'attr' => ['data-remove-item' => '.variation'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OfferVariation::class,
        ]);
    }
}
