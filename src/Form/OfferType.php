<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
//            ->add('picture')
            ->add('domainName')
            ->add('language', CollectionType::class, [
                'required' => false,
                'entry_type' => CheckboxType::class,
                'entry_options' => [
                    'attr' => ['class' => 'form-control'],
                ],
            ])
            ->add('description', DescriptionType::class)
            ->add('contact', ContactType::class)
            ->add('offerVariations', OfferVariationType::class, [
                'data_class' => null,
                ])

//            ->add('provider')
//            ->add('description')
//            ->add('contact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
