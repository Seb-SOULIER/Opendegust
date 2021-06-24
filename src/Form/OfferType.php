<?php

namespace App\Form;

use App\Entity\Offer;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'entry_type' => TextType::class,
                'entry_options' => [
                    'attr' => ['class' => 'form-control'],
                ],
            ])

//                CollectionType::class
//                , [
//                CheckboxType::class,[
//                'label'    => 'Show this entry publicly?',
//                'required' => false,
//                ]
//                CollectionType::class, [
//                'entry_type' => CheckboxType::class,
//                'entry_options' => [
//                    'attr' => ['class' => 'form-control'],
//                ],
//            ])
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
