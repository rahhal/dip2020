<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\LineRequestSupplied;
use App\Entity\RequestSupplied;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineRequestSuppliedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('article', EntityType::class, [
                'class' => Article::class,
                'multiple' => false
            ])
            ->add('requestSupplied', EntityType::class, [
                'class' => RequestSupplied::class,
                'multiple' => false
            ])
            ->add('quantity')
            ->add('remarque')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineRequestSupplied::class,
        ]);
    }
}
