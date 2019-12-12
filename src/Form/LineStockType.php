<?php

namespace App\Form;

use App\Entity\lineStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qty_update')
            ->add('date')
            ->add('old_qty')
            ->add('quantity_alerte')
            ->add('valid_date')
            ->add('prod_date')
            ->add('article')
            ->add('line_purchase')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => lineStock::class,
        ]);
    }
}
