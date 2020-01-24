<?php

namespace App\Form;

use App\Entity\Exitt;
use App\Entity\Journal;
use App\Entity\LineExitt;
use App\Entity\Menu;
use App\Entity\NbMeal;
use App\Entity\User;
use App\Repository\ExittRepository;
use App\Repository\NbMealRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('date')
            ->add('date', DateType::class, [
                'label' => 'Date :',
                // 'format'=> 'mm/dd/yyyy',
                'widget' => 'single_text',
                //'html5' => false,
                /* 'attr' => ['class' => 'js-datepicker',
                 'autocomplete' => 'off'
            ],*/
            ])
          //  ->add('totalCosts')
           // ->add('total_meals')
            ->add('unit_cost')
            ->add('remarque')
            // ->add('nbMeal')
            //->add('exitt')
            ->add('save',SubmitType::class)
        ;

	    $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
		    $form = $event->getForm();
		    $form->add('nbMeal', EntityType::class, [
		    	'class' => NbMeal::class,
			    'query_builder' => function (NbMealRepository $mealRepository) {
				      return $mealRepository->findByCurrentDate();
			    },
		    ]);
	    });
         $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
             $form = $event->getForm();
             $form->add('exitt', EntityType::class, [
	             'class' => Exitt::class,
	             'choice_label' => function(Exitt $user) {
		             return sprintf($user->getTotalPrice());
	             }
            ]);
         });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Journal::class,
        ]);
    }
}
