<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('rIB')
            ->add('email')
            ->add('password')
            ->add('company')
            ->add('director')
            ->add('address')
            ->add('city', EntityType::class, array(
                'class' => City::class,
                'choice_label' => 'name',
                'attr' => array('placeholder' => 'المدينة'
                )))
            ->add('phone')
            ->add('fullname')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
