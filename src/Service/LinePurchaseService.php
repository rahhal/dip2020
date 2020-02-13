<?php

namespace App\Service;

use App\Entity\LinePurchase;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LinePurchaseRepository;
use Doctrine\ORM\EntityRepository;
class LinePurchaseService
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function calculPrice(LinePurchase $linePurchase)
    {
        $t_price= $linePurchase->getQuantityDelivred() * $linePurchase->getUnitPrice() * (1 + ($linePurchase->getTax() / 100));
       return($t_price);
        
    }
}