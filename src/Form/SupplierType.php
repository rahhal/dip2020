<?php

namespace App\Form;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company',TextType::class)
            ->add('name',TextType::class)
            ->add('activity',TextType::class)
            ->add('tax_number',TextType::class)
            ->add('phone',TelType::class)
            ->add('address',TextType::class)
            ->add('email',EmailType::class)
           // ->add('purchase')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}
