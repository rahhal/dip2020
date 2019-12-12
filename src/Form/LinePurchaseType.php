<?php

namespace App\Form;

use App\Entity\LinePurchase;
use App\Entity\Purchase;
use App\Entity\Article;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class LinePurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'multiple' => false
            ])
           // ->add('unit')
            ->add('purchase', EntityType::class, [
               'class' => Purchase::class,
              'multiple' => false
              ])
            ->add('quantity_delivred')
            ->add('unit_price')
            ->add('tax')
            ->add('quantity_required')
            ->add('technical_confirmity')
            ->add('total_price')
           ->add('remarque')
            //->add('production')
            ->add('validation')
            ->add('production', DateType::class, array('label' => 'Date de début', 'required' => true, 'format' => 'dd/MM/yyyy', 'widget' => 'single_text', 'html5' => false,
                'attr' => ['class' => 'datepicker', 'autocomplete' => 'off'],
            ))
           // ->add('valid')
           // ->add('prod')
           //->add('exit_dte',TextType::class, array('widget' => 'single_text','required' => false,'empty_data'=>'null'))
          //  ->add('prod_dte',TextType::class, array('widget' => 'single_text','required' => false,'empty_data'=>'null'))
           /* ->add('prod_dte', DateType::class, [
               // 'label' => 'prod dte',
               // 'widget' => 'single_text',
               // 'html5' => false,
                'empty_data' => null,
                //'attr' => ['id' => 'purchase_linePurchase___name___prod_dte'],
                'format' => 'y-M-d',
                'input' => 'datetime',
            ])
           /* ->add('DateOfBirth', TextType::class, array(
                'required' => false,
                'empty_data' => null,
                'attr' => array(
                    'placeholder' => 'mm/dd/yyyy'
                )))*/


         /*   ->add('exit_dte', DateType::class, [
               // 'label' => 'validity dte',
               // 'widget' => 'single_text',
               // 'html5' => false,
               // 'attr' => ['id' => 'purchase_linePurchase___name___validity_dte'],
                'format' => 'y/M/d',
                'input' => 'datetime',
            ])*/



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LinePurchase::class,
           // 'allow_extra_fields' => true,
        ]);
    }
}
