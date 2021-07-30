<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class CustomerType extends AbstractType
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
            ->add('lastname', TextType::class, [
                'required' => false
            ])
            ->add('firstname', TextType::class, [
                'required' => false
            ])
            ->add('civility', ChoiceType::class, [
                'choices'  => [
                    'Homme' => true,
                    'Femme' => false,
                ],
            ])
//            ->add('isVerified')
            ->add('birthdate', BirthdayType::class, [
                'html5'  => false,
                'format' => 'ddMMyyyy',
                'required' => false,
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'
                ]
            ])
            ->add('knowUs', ChoiceType::class, [
                'choices' => [
                    'Réseaux sociaux' => 'Réseaux sociaux',
                    'Google' => 'Google',
                    'Bouche à oreille' => 'Bouche à oreille',
                    'Autre' => 'Autre'
                ]
            ])
            ->add('gtc18', CheckboxType::class, [
//                'mapped' => false,
                'label' => 'Je confirme avoir 18 ans ou plus',
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez confirmer votre âge",
                    ]),
                ],
            ])
            ->add('contact', ContactCustomerType::class, [
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
