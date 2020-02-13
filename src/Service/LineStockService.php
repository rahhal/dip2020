<?php

namespace App\Service;
use App\Entity\LineStock;
use App\Entity\LinePurchase;
use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DateTime;
class LineStockService
{
    protected $em;
    /**
     * @param EntityManagerInterface $em
     */
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

    // public function updateStock(LineStock $lineStock)
    // {
    //     foreach ($purchase->getLinePurchases() as $linePurchase) {
    //         //  faire mise à jour du stock: find Line Purchase By Article
    //         $myStock= $lineStock->newStock($linePurchase);
    //         if ($myStock) {
	// 	                /* unit price */
    //                     $myStock->setUnitPrice($linePurchase->getUnitPrice());
    //                     $myStock->setProdDate(new \DateTime($linePurchase->getProduction()));
    //                     $myStock->setValidDate(new \DateTime($linePurchase->getValidation()));

    //                     $old_quantity = $myStock->getQtyUpdate();
    //                     $new_quantity = $linePurchase->getQuantityDelivred();
    //                     $myStock->setQtyUpdate($old_quantity + $new_quantity);
    //                     $myStock->setOldQty($old_quantity);
	// 		            $em->flush();
	// 	            } else {
	// 	            	$lineStock = new LineStock();
	// 	            	$lineStock->setLinePurchase($linePurchase);
	// 	            	$lineStock->setQtyUpdate($linePurchase->getQuantityDelivred()+$linePurchase->getArticle()->getIniQty());
	// 	            	 $lineStock->setDate(new \DateTime('now'));
	// 	            	$lineStock->setOldQty($linePurchase->getArticle()->getIniQty());
	// 	            	$lineStock->setQuantityAlerte($linePurchase->getArticle()->getMinQty());
    //                     $lineStock->setProdDate(new \DateTime($linePurchase->getProduction()));
    //                     $lineStock->setValidDate(new \DateTime($linePurchase->getValidation()));
	// 	            	$lineStock->setReference($linePurchase->getArticle()->getReferenceStock());
    //                     $lineStock->setUnitPrice($linePurchase->getUnitPrice());

	// 	            	 /*$lineStock->setStock($stock);*/
	// 	            	 $em->persist($lineStock);
	// 	            }
	//              }



    //}
}