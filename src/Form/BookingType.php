<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('adultPlaces', ChoiceType::class, [
            'mapped' => false,
            'label' => "Nombre d'adultes :",
        ])
        ->add('childPlaces', ChoiceType::class, [
            'mapped' => false,
            'label' => "Nombre d'enfants :",
        ])
//            ->add('places')
//            ->add('priceVariationBook')
//            ->add('totalPrice')
//            ->add('createdAt')
//            ->add('vat')
//            ->add('totalPlaces')
//            ->add('customer')
//            ->add('offerVariation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}