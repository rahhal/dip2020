<?php

namespace App\Form;

use App\Entity\LineRequestSupplied;
use App\Entity\RequestSupplied;


use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            //->add('date')
            ->add('date', DateType::class, [
                'label' => 'Date :',
               // 'format'=> 'mm/dd/yyyy',
                'widget' => 'single_text',
                'required'=> false,
                //'html5' => false,
                /*'attr' => ['class' => 'js-datepicker',
                    'autocomplete' => 'off'
                ],*/
            ])
            ->add('tranche',TextType::class,['required'=> false,])
            ->add('supplier',EntityType::class,['class'=>Supplier::class])
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
