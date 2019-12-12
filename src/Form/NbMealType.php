<?php

namespace App\Form;

use App\Entity\NbMeal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NbMealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('std_resident')
            ->add('std_semiResident')
            ->add('std_granted')
            ->add('professor')
            ->add('curators')
            ->add('employee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NbMeal::class,
        ]);
    }
}
