<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Purchase;
use App\Entity\LinePurchase;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number',TextType::class,['required'=> true])
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
            ->add('employee',EntityType::class,['class' => Employee::class,'required'=> true])
            ->add('supplier',EntityType::class,['class' => Supplier::class,'required'=> true])
            ->add('linePurchases', CollectionType::class, array(
                'entry_type'   => LinePurchaseType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))
            ->add('totalPrice',TextType::class)
           ->add('save',      SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
            'allow_extra_fields' => true,
        ]);
    }
}
