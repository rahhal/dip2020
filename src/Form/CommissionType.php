<?php

namespace App\Form;

use App\Entity\Commission;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CommissionType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::Class,[
                'widget' => 'single_text',
            ])
            //->add('employee', EmployeeType::class)
            /*->add('employee', EntityType::class, [
                'class' => Employee::class,
                'multiple' => false,
                'expanded' => false
            ])*/
            //->add('User', HiddenType::class)
        ;
        $user = $this->security->getUser();

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('employee', EntityType::class, [
                'class' => Employee::class,
                'query_builder' => function (EmployeeRepository $employeeRepository)use ($user) {
                    return $employeeRepository->findByCurrentUser($user);
                },
            ]);

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commission::class,
        ]);
    }
}
