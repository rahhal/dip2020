<?php

namespace App\Form;

use App\Entity\LineExitt;
use App\Entity\Exitt;
use App\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineExittType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'multiple' => false
            ])
            ->add('exitt', EntityType::class, [
                'class' => Exitt::class,
                'multiple' => false
            ])
            ->add('quantity')
            ->add('unit_price')
            ->add('tax')
            ->add('total_price')
            //->add('journal')
           // ->add('lineStocks')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineExitt::class,
        ]);
    }
}
