<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->add('date')
            ->add('day',ChoiceType::class, ['choices'  => [
                /*'Monday'=>'الاثنين',
               'Tuesday'=>'الثلاثاء',
               'Wednesday'=>'الأربعاء',
               'Thursday'=>'الخميس',
               'Friday'=>'الجمعة',
               'Saturday'=> 'السبت',
               'Sunday'=>'الأحد',*/
               'Monday'=>'Monday',
               'Tuesday'=>'Tuesday',
               'Wednesday'=>'Wednesday',
               'Thursday'=>'Thursday',
               'Friday'=>'Friday',
               'Saturday'=> 'Saturday',
               'Sunday'=>'Sunday',
               ]
           ])
            ->add('breakfast',TextType::class)
            ->add('lunch',TextType::class)
            ->add('dinner',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
