<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Unit;
//use App\Form\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->add('lineStock')
            ->add('reference_stock')
            /*->add('created_at', DateType::class, [

                    'widget' => 'single_text',
            ])
            ->add('name')*/
            ->add('created_at', DateType::class)
            ->add('name')
          //  ->add('unit')
            ->add('unit',EntityType::class, [
                'class' => Unit::class,
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('Category')
            ->add('ini_qty')
            ->add('min_qty')
            /* ->add('category',EntityType::class, array(
                'class' => 'App:Category',
                'choice_label' => 'name',
                'label' => 'Categorie :')) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
