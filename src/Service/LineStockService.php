<?php

namespace App\Service;
use App\Entity\LineStock;
use App\Entity\LinePurchase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
class LineStockService
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function newStock($linePurchase)
    {
            $repositoryLinePurchase =$this->em->getRepository(LinePurchase::class);
            $repositoryLineStock =$this->em->getRepository(LineStock::class);
            $findLinePurchaseByArticle = $repositoryLinePurchase->findOneBy(['article' => $linePurchase->getArticle()]);
            $findLineStockByLinePurchase = $repositoryLineStock->findOneBy(['line_purchase' => $findLinePurchaseByArticle]);
             return($findLineStockByLinePurchase );
         
    }
}