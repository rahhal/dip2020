<?php

namespace App\Form;

use App\Entity\Budget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             //->add('year')
            ->add('year', DateType::class, [
                'label' => 'التاريخ :',
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                 'format' => 'mm/dd/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('amount')
            ->add('name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
        ]);
    }
}
