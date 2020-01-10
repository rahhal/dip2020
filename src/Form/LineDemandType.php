<?php

namespace App\Form;

use App\Entity\LineDemand;
use App\Entity\Demand;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineDemandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'multiple' => false
            ])
           /* ->add('demand', EntityType::class, [
                'class' => Demand::class,
                'multiple' => false
            ])*/
            ->add('quantity')
            ->add('remarque')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineDemand::class,
        ]);
    }
}
