<?php

namespace App\Form;

use DateTime;
use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $theDate    = new DateTime('now');
        $stringDate = $theDate->format('Y-m-d\TH:i');

        $builder
            ->add('startAt', DateTimeType::class, [
                'choice_translation_domain' => true,
                'widget' => 'single_text',
                'input'  => 'datetime',
                'html5' => true,
                'attr' => ['class' => 'form-control js-datepicker', 'min' => $stringDate],
                'label' => 'Date et heure :'
            ])
            ->add('delete', ButtonType::class, [
                'label' => 'Supprimer cette date',
                'attr' => ['data-remove-item' => '.calendar'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
