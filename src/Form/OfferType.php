<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('imgOffer', VichFileType::class, [
                'required' => false,
//                'download_label' => new PropertyPath('picture'),
                'allow_delete' => false,
//                'delete_label' => 'Supprimer',
                'download_uri' => false,
            ])
            ->add('domainName')
            ->add('description', DescriptionType::class)
            ->add('contact', ContactProviderType::class)
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
            ->add('variation', ButtonType::class, [
                'attr' => ['class' => 'btn btn-success btn-pos', 'data-collection-holder-class' => 'variations'],
                'label' => 'Ajouter une variation'
            ])

            ->add('offerVariations', CollectionType::class, [
                'attr' => ['class' => 'variations', 'data-items' => '.calendars'],
                'entry_type' => OfferVariationType::class,
                'entry_options' => ['label' => false, 'attr' => ['class' => 'variation']],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
