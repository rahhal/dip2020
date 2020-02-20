<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Purchase;
use App\Entity\LinePurchase;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class PurchaseEditType extends AbstractType
{
    
        public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->remove('date')
            
            ->remove('save')

        ;
    }

    public function getParent()
    {
        return PurchaseType::class;
    }
}
