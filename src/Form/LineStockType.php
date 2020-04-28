<?php

namespace App\Form;

use App\Entity\lineStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qty_update')
            ->add('date',DateType::class)
            ->add('old_qty')
            ->add('unitPrice')
            ->add('quantity_alerte')
            ->add('valid_date',DateType::class)
            ->add('prod_date',DateType::class)
            ->add('article',ArticleType::class)
            ->add('line_purchase',LinePurchaseType::class)
            ->add('stock')
           // ->add('user',HiddenType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => lineStock::class,
        ]);
    }
}
