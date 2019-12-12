<?php

namespace App\Form;

use App\Entity\LineRequestSupplied;
use App\Entity\RequestSupplied;


use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestSuppliedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('tranche')
            ->add('supplier')
            ->add('lineRequestSupplieds', CollectionType::class, array(
                'entry_type'   => LineRequestSuppliedType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))

            ->add('save',      SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RequestSupplied::class,
        ]);
    }
}
