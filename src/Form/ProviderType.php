<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Provider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('civility', ChoiceType::class, [
                'choices'  => [
                    '' => null,
                    'Mr' => true,
                    'Mme' => false,
                ],
            ])
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('company', TextType::class)
            ->add('picture', TextType::class)
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
//            ->add('otherSite', TextType::class)
//            ->add('knowUs', ChoiceType::class, [
//                'choices' => [
//                    'Par la Wild Code School' => 'Wild Code School'
//                ]
//            ])
//            ->add('address', EntityType::class, [
//                'class' => Contact::class,
//                'choice_label' => 'address',
//                'by_reference' => false
//            ]);
//            ->add('contact', null, ['choice_label' => 'zip_code'])
//            ->add('contact', null, ['choice_label' => 'city'])
//            ->add('contact', null, ['choice_label' => 'phone'])
//            ->add('contact', null, ['choice_label' => 'phone2'])
//            ->add('contact', null, ['choice_label' => 'website'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Provider::class
        ]);
    }
}
