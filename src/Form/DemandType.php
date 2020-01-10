<?php

namespace App\Form;

use App\Entity\Demand;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,  [
                'label' => 'التاريخ :',
                'required' => true,
                'widget' => 'single_text',
                //'html5' => false,
                // 'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('tranche')
            ->add('supplier',EntityType::class,['class' => Supplier::class,'required'=> true])
           /* ->add('lineDemands', CollectionType::class, array(
                'entry_type'   => LineDemandType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))*/
           // ->add('save',      SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demand::class,
        ]);
    }
}
