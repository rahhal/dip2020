<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('company',TextType::class)
            ->add('director',TextType::class)
            ->add('rIB', TextType::class)
            ->add('address',TextType::class)
            ->add('city', EntityType::class, array(
                'class' => City::class,
                'choice_label' => 'name',
                'attr' => array('placeholder' => 'المدينة'
                )))
            ->add('phone',TelType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
