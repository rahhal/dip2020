<?php

namespace App\Form;

use App\Entity\NbMeal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NbMealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date :',
                // 'format'=> 'mm/dd/yyyy',
                'widget' => 'single_text',
                //'html5' => false,
                /* 'attr' => ['class' => 'js-datepicker',
                 'autocomplete' => 'off'
            ],*/
            ])
            ->add('std_resident',NumberType::class,['required'=>false])
            ->add('std_semiResident',NumberType::class,['required'=>false])
            ->add('std_granted',NumberType::class,['required'=>false])
            ->add('professor',NumberType::class,['required'=>false])
            ->add('curators',NumberType::class,['required'=>false])
            ->add('employee',NumberType::class,['required'=>false])
           // ->add('user',HiddenType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NbMeal::class,
        ]);
    }
}
