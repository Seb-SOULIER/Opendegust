<?php

namespace App\Form;

use App\Entity\Offer;
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
            ->add('language', ChoiceType::class, array(
                'mapped' => false,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'label' => 'lang',
                'choices' => array(
                    'I have a job. # of hours/week:' => 'have_job',
                    'I am work study eligible' => 'work_study',
                    'I need assistance in finding a job' => 'find_work',
                    'I need to learn interviewing skills' => 'interview',
                    'I have no employment needs at this time' => 'no_needs',
                    'I volunteer for a non-profit organization' => 'non_profit',
                    'I need assistance with my resume' => 'resume',
                    'I need assistance finding an internship' => 'intern',
                    'I am undecided about my career or major' => 'major',
                    'Other:' => 'other',
                )));

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
