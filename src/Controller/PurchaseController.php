<?php
namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Institution;
use App\Entity\LinePurchase;
use App\Entity\LineStock;
use App\Entity\Stock;
use App\Entity\Purchase;
use App\Entity\Article;
use App\Form\PurchaseType;
use App\Repository\PurchaseRepository;
use App\Repository\LinePurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/purchase")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class PurchaseController extends AbstractController
{  /**
 * @Route("/", name="purchase_index", methods={"GET"})
 */
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchaseRepository->findAll(),
        ]);
    }
    /**
     * @Route("/ajout/purchase", name="ajout-purchase")
     * @Route("/modifier/purchase/{id}", name="modifier-purchase")
     * @Route("/new", name="purchase_new")
     *
     */
    public function purchase($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
        {
            $purchase = new Purchase();
            $stock = new stock();
            //$article = new Article();

        }
        else
        {    $purchase = $em->find(Purchase::class, $id);
        }
        $form = $this->createForm(PurchaseType::class, $purchase);
        $oldLinePurchase = new ArrayCollection();
        foreach ($purchase->getLinePurchases() as $linePurchase) {
	        $oldLinePurchase->add($linePurchase);
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
	            foreach ($oldLinePurchase as $linePurchase) {
		            if (false === $purchase->getLinePurchases()->contains($linePurchase))
			            $em->remove($linePurchase);
	            }

	           $stock->setName('stoki');
               // $stock->setType('stock produit alimentaires');
	            $em->persist($stock);

	            /* ----  calcul du prix total de chaque line_purchase    ------*/
	            foreach ($purchase->getLinePurchases() as $linePurchase) {
		            $linePurchase->setTotalPrice($linePurchase->getQuantityDelivred()*$linePurchase->getUnitPrice()*(1+($linePurchase->getTax()/ 100)));
		            $linePurchase->setPurchase($purchase);
		            // find Line Purchase By Article: faire mise à jour du stock
		            $repositoryLinePurchase = $this->getDoctrine()->getRepository(LinePurchase::class);
		            $repositoryLineStock = $this->getDoctrine()->getRepository(LineStock::class);
		            $findLinePurchaseByArticle = $repositoryLinePurchase->findOneBy(['article' => $linePurchase->getArticle()]);
		            $findLineStockByLinePurchase = $repositoryLineStock->findOneBy(['line_purchase' => $findLinePurchaseByArticle]);

		            if ($findLineStockByLinePurchase) {
			            $old_quantity = $findLineStockByLinePurchase->getQtyUpdate();
			            //$new_quantity = $linePurchase->getQuantityDelivred()+$linePurchase->getArticle()->getIniQty();
                        $new_quantity = $linePurchase->getQuantityDelivred();
                       // $unit_price = $linePurchase->getUnitPrice();
                        $findLineStockByLinePurchase->setQtyUpdate($old_quantity + $new_quantity);
                        $findLineStockByLinePurchase->setOldQty($old_quantity);
                       // $findLineStockByLinePurchase->setUnitPrice($unit_price);

			            $em->flush();
		            } else {
		            	$lineStock = new LineStock();
		            	$lineStock->setLinePurchase($linePurchase);
		            	$lineStock->setQtyUpdate($linePurchase->getQuantityDelivred()+$linePurchase->getArticle()->getIniQty());
		            	$lineStock->setDate(new \DateTime('now'));
		            	$lineStock->setOldQty($linePurchase->getArticle()->getIniQty());
		            	$lineStock->setQuantityAlerte($linePurchase->getArticle()->getMinQty());
		            	$lineStock->setProdDate(new \DateTime('now'));
		            	$lineStock->setValidDate(new \DateTime('now'));
                       /*$lineStock->setProdDate($linePurchase->getProduction());
                        $lineStock->setValidDate($linePurchase->getValidation());*/
		            	$lineStock->setReference($linePurchase->getArticle()->getReferenceStock());
		            	$lineStock->setStock($stock);

		            	$em->persist($lineStock);
		            }
	            }

	            /* ------ calcul du prix total de chaque purchase -------*/
	            $totalPrice=0;
	            foreach ($purchase->getLinePurchases() as $linePurchase) {
		            $totalPrice += $linePurchase->getTotalPrice();
	            }
	            $purchase->setTotalPrice($totalPrice);

	            $em->persist($purchase);
                $em->flush();
                
                $this->addFlash('success', "تمت الاضافة بنجاح");
                return $this->redirectToRoute("purchase_index");
            }
        }
        $purchases = $em->getRepository(Purchase::class)->findAll();
        $articles = $em->getRepository(Article::class)->findAll();
        $linePurchase=$this->getDoctrine()
            ->getRepository(LinePurchase::class)
            ->findLinePurchaseByPurchase($id);
        return $this->render('purchase/purchase.html.twig', array(
            'form' => $form->createView(),
            'purchases' => $purchases,
            'articles' => $articles,
            'linePurchases' => $linePurchase,
        ));
    }
    /**
     * @Route("/{id}", name="purchase_show", methods={"GET"})
     */
    public function show(Purchase $purchase): Response
    {
        return $this->render('purchase/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }
    /**
     * @Route("/delete/purchase/{id}", name="purchase_delete")
     *
     */
    public function delete(Purchase $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");
        return new Response(1);
    }

    /**
     * @Route("/pdf/purchase/{id}", name="purchase_pdf")
     *
     */

    public function pdf($id = null)
    {
        $purchases = $this->getDoctrine()
            ->getRepository(Purchase::class)
            ->myFindOne($id);

     $linePurchase=$this->getDoctrine()
            ->getRepository(LinePurchase::class)
            ->findLinePurchaseByPurchase($id);

        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/purchase.html.twig', array(
            'purchases' => $purchases,
            'line_purchases' => $linePurchase,
            'title' =>"وصل دخول",
            'institution'=> $institution,
        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
    /**
     * * @Route("/receive/purchase/{id}", name="receive_pdf")
     *
     */

    public function receive($id = null)
    { $purchases =$this->getDoctrine()
        ->getRepository(Purchase::class)->findAll();

        $linePurchase=$this->getDoctrine()
            ->getRepository(LinePurchase::class)
            ->findLinePurchaseByPurchase($id);

        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();
        $commission= $this->getDoctrine()
            ->getRepository(Commission::class)->findAll();
        $html = $this->renderView('pdf/receive.html.twig', array(
            'purchases' => $purchases,
            'line_purchases' => $linePurchase,
            'title' =>"محضر جلسة استلام المواد",
           'commissions'=>$commission,
           'institution'=> $institution,
        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
}