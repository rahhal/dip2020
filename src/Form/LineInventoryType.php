<?php

namespace App\Form;

use App\Entity\LineInventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineInventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->add('qty_th')
            ->add('qty_inv')
            //->add('difference')
            ->add('article')
           // ->add('inventory')
         //  ->add('lineStock')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineInventory::class,
        ]);
    }
}
