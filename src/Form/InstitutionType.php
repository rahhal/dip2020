<?php

namespace App\Form;

use App\Entity\Institution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ministry', TextType::class, array('label' => 'اسم الوزارة :', 'attr' => array('placeholder' => 'اسم الوزارة')))
            ->add('office', TextType::class, array('label' => 'اسم الديوان   :', 'attr' => array('placeholder' => 'اسم الديوان')))
            ->add('name', TextType::class, array('label' => 'اسم المؤسسة   :', 'attr' => array('placeholder' => 'اسم المدير')))
            ->add('director', TextType::class, array('label' => 'اسم المدير  :', 'attr' => array('placeholder' => 'اسم المقتصد')))
            ->add('economist', TextType::class, array('label' => 'اسم المقتصد   :', 'attr' => array('placeholder' => 'اسم المقتصد')))
            ->add('administrator', TextType::class, array('label' => 'اسم المؤسسة   :', 'attr' => array('placeholder' => 'اسم المؤسسة')))
            ->add('address', TextareaType::class, array('label' => 'العنوان  :', 'attr' => array('placeholder' => 'العنوان')))
            ->add('city', TextType::class, array('label' => ' المدينة:', 'attr' => array('placeholder' => 'المدينة')))
            ->add('phone', TextType::class, array('label' => 'الهاتف :', 'attr' => array('placeholder' => 'الهاتف')))
            ->add('fax', TextType::class, array('label' => 'الفاكس :', 'attr' => array('placeholder' => 'الفاكس')))
            ->add('year', TextType::class, array('label' => 'السنة الدراسية :', 'attr' => array('placeholder' => 'السنة الدراسية')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Institution::class,
        ]);
    }
}
