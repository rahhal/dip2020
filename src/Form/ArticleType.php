<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Unit;
//use App\Form\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

         ->add('created_at', DateType::class/*, [
                     'label' => 'التاريخ :',
                     'required' => true,
                     'widget' => 'single_text',
                     'html5' => false,
                    'format' => 'dd/MM/yyyy',
                    'attr' => ['class' => 'js-datepicker',
                    'autocomplete' => 'off'
               ],
            ]*/)
            ->add('reference_stock', TextType::class, array('label' => 'المرجع بالمخزن :', 'attr' => array('placeholder' => 'المرجع بالمخزن')))
           // ->add('created_at', DateType::class)
            ->add('name', TextType::class, array('label' => 'اسم المادة :', 'attr' => array('placeholder' => 'اسم المادة')))
            ->add('unit',EntityType::class, [
                'class' => Unit::class,
                'label' => ' الوحدة :',
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('Category', EntityType::class, array('class' => Category::class,'label' => ' الصنف :', 'attr' => array('placeholder' => ' الصنف')))
            ->add('ini_qty', TextType::class, array('label' => ' الكمية الاولية :', 'attr' => array('placeholder' => ' الكمية الاولية')))
            ->add('min_qty', TextType::class, array('label' => ' الكمية الدنيا :', 'attr' => array('placeholder' => ' الكمية الدنيا')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
