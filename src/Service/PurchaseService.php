<?php

namespace App\Service;

use App\Entity\Purchase;



class PurchaseService
{

    public function calculTotalPrice(Purchase $purchase)
    {
        $totalPrice=0;
        foreach ($purchase->getLinePurchases() as $linePurchase) {
            $totalPrice += $linePurchase->getTotalPrice();
        }
       // $purchase->setTotalPrice($totalPrice)
        return($totalPrice);
    }
}