<?php

namespace App\Form;

use App\Entity\LinePurchase;
use App\Entity\Purchase;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;
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
            ->add('quantity_delivred',TextType::class)
            ->add('unit_price',TextType::class)
            ->add('tax',TextType::class)
            ->add('quantity_required',TextType::class)
            ->add('technical_confirmity',CheckboxType::class, array('required' => false))
            ->add('total_price',TextType::class)
           ->add('remarque',TextType::class)
            ->add('validation',TextType::class)
            ->add('production', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LinePurchase::class,
        ]);
    }
}
