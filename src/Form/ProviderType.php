<?php

namespace App\Form;

use App\Entity\Provider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => "L'adresse email n'est pas la même",
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Email'],
                'second_options' => ['label' => "Confirmation de l'email"],
            ])
            ->add('civility', ChoiceType::class, [
                'choices'  => [
                    'Homme' => true,
                    'Femme' => false,
                ],
            ])
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('company', TextType::class)
            ->add('socialReason', ChoiceType::class, [
                'choices' => [
                    'SARL' => 'SARL',
                    'EURL' => 'EURL',
                    'SAS' => 'SAS',
                    'SASU' => 'SASU',
                    'SA' => 'SA',
                    'EI' => 'EI'
                ]
            ])
            ->add('siret', NumberType::class)
            ->add('vatNumber', NumberType::class)
            ->add('knowUs', ChoiceType::class, [
                'choices' => [
                    'Réseaux sociaux' => 'Réseaux sociaux',
                    'Google' => 'Google',
                    'Bouche à oreille' => 'Bouche à oreille',
                    'Autre' => 'Autre'
                ]
            ])
            ->add('contact', ContactProviderType::class, [
                'by_reference' => false
            ])

//            ->add(
//                $builder
//                    ->create('otherSite', TextType::class)
//            )
            ->add('files', CollectionType::class, [
                'entry_type' => FileType::class,
                'required' => false,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
//                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Provider::class
        ]);
    }
}
