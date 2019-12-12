<?php

namespace App\Form;

use App\Entity\Journal;
use App\Entity\LineExitt;
use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('total_meals')
            ->add('totalCosts')
            ->add('unit_cost')
            ->add('remarque')
            ->add('menu')
            ->add('nbMeal',NbMealType::class)
           ->add('exitt')

            ->add('save',  SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Journal::class,
        ]);
    }
}
