<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\OfferVariation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture')
            ->add('domainName')
            ->add('description', DescriptionType::class)
            ->add('contact', ContactType::class)
            ->add('language', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'row_attr' => ['class' => 'text-editor'],
                'choices' => [
                    'Francais' => 'Francais',
                    'Anglais' => 'Anglais',
                    'Portugais' => 'Portugais' ,
                    'Chinois' => 'Chinois',
                    'Japonais' => 'Japonais',
                    'Espagnol' => 'Espagnol',
                    'Russe' => 'Russe',
                ],
            ])
            ->add('offerVariations', CollectionType::class, [
                'entry_type' => OfferVariationType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
