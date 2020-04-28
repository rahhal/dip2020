<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Unit;
use App\Entity\User;
//use App\Form\EntityType;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ArticleType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

         ->add('created_at', DateType::class, [
	         'widget' => 'single_text',
	         'format' => 'yyyy-MM-dd',
             ])
            ->add('reference_stock', TextType::class, array('label' => 'المرجع بالمخزن :', 'attr' => array('placeholder' => 'المرجع بالمخزن')))
            ->add('name', TextType::class, array('label' => 'اسم المادة :', 'attr' => array('placeholder' => 'اسم المادة')))
            ->add('unit',EntityType::class, [
                'class' => Unit::class,
                'label' => ' الوحدة :',
                'choice_label' => 'name',
                'required'=> false,
                // 'multiple' => true,
                // 'expanded' => true,
            ])
           // ->add('Category', EntityType::class, array('class' => Category::class,'label' => ' الصنف :', 'attr' => array('placeholder' => ' الصنف')))
            ->add('ini_qty', TextType::class, array('label' => ' الكمية الاولية :', 'attr' => array('placeholder' => ' الكمية الاولية')))
            ->add('min_qty', TextType::class, array('label' => ' كمية الانذار :', 'attr' => array('placeholder' => ' الكمية الدنيا')))
            // ->add('User', EntityType::class, array('class' => User::class,'label' => ' المستخدم :', 'attr' => array('placeholder' => ' المستخدم')))
           // ->add('User', HiddenType::class)

            ;
        $user = $this->security->getUser();

       /* if (!$user) {
            throw new \LogicException(
                'The ArticleType cannot be used without an authenticated user!'
            );
        }*/

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('Category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $categoryRepository)use ($user) {
                    return $categoryRepository->findByCurrentUser($user);
                },
            ]);

        });
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
