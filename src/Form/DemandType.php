<?php

namespace App\Form;

use App\Entity\Demand;
use App\Entity\Employee;
use App\Entity\Supplier;
use App\Repository\SupplierRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class DemandType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,  [
                'label' => 'التاريخ :',
                'required' => true,
                'widget' => 'single_text',
                //'html5' => false,
                // 'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('tranche')
            //->add('supplier',EntityType::class,['class' => Supplier::class,'required'=> true])
           /* ->add('lineDemands', CollectionType::class, array(
                'entry_type'   => LineDemandType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))*/
           // ->add('save',      SubmitType::class)
          // ->add('User', HiddenType::class)
        ;
        $user = $this->security->getUser();

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'query_builder' => function (SupplierRepository $supplierRepository)use ($user) {
                    return $supplierRepository->findByCurrentUser($user);
                },
            ]);

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demand::class,
        ]);
    }
}
