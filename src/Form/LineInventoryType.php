<?php

namespace App\Form;

use App\Entity\LineInventory;
use App\Entity\LineStock;
use App\Repository\LineStockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineInventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qty_inv')
            ->add('article')
           // ->add('inventory')
//           ->add('lineStock')
        ;
       /* $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $form->add('lineStock', EntityType::class, [
                'class' => LineStock::class,
                'query_builder' => function (LineStockRepository $lineStockRepository) {
                    return $lineStockRepository->findByCurrentDate();
                },
            ]);
        });*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineInventory::class,
        ]);
    }
}
