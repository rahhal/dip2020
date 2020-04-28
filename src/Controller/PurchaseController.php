<?php
namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Institution;
use App\Entity\LinePurchase;
use App\Entity\LineStock;
use App\Entity\Stock;
use App\Entity\Purchase;
use App\Entity\Article;
use App\Service\PurchaseService;
use App\Service\LinePurchaseService;
use App\Service\LineStockService;
use App\Form\PurchaseType;
use App\Form\PurchaseEditType;
use App\Repository\PurchaseRepository;
use App\Repository\LinePurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/purchase")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class PurchaseController extends AbstractController
{  /**
 * @Route("/", name="purchase_index", methods={"GET"})
 */
    public function index(PurchaseRepository $purchaseRepository): Response
    {  //$em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        //$purchases = $em->getRepository(Purchase::class)->findPurchaseByUser($id);
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchaseRepository->findPurchaseByUser($id),
        ]);
    }
    /**
     * @Route("/ajout/purchase", name="ajout-purchase")
     * @Route("/new", name="purchase_new")
     *
     */
    public function purchase($id = null, Request $request, PurchaseService $purchaseService, LinePurchaseService $linePurchaseService, LineStockService $lineStockService)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
        {
            $purchase = new Purchase();
            $stock = new stock();
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
                  /* ------ calcul du prix total de chaque line_purchase -------*/
                $user = $this->getUser();
                $purchase->setUser($user);
            foreach ($purchase->getLinePurchases() as $linePurchase) {
                $linePurchase->setTotalPrice($linePurchaseService->calculPrice($linePurchase));
                $linePurchase->setPurchase($purchase);
            }
               /* ------ calcul du prix total de chaque purchase -------*/
            $purchase->setTotalPrice($purchaseService->calculTotalPrice($purchase));
            /*------------- calcul de lineStock ------------------------*/
	            $stock->setName('stoki');
	            $user = $this->getUser();
	            $stock->setUser($user);

	             $em->persist($stock);

	            foreach ($purchase->getLinePurchases() as $linePurchase) {
		            //  faire mise à jour du stock: find Line Purchase By Article
                   $myStock= $lineStockService->newStock($linePurchase);
                    if ($myStock) {
		                /* unit price */
                        $myStock->setUnitPrice($linePurchase->getUnitPrice());
                        $myStock->setProdDate(new \DateTime($linePurchase->getProduction()));
                        $myStock->setValidDate(new \DateTime($linePurchase->getValidation()));

                        $old_quantity = $myStock->getQtyUpdate();
                        $new_quantity = $linePurchase->getQuantityDelivred();
                        $myStock->setQtyUpdate($old_quantity + $new_quantity);
                        $myStock->setOldQty($old_quantity);

                        $myStock->setUser($user);

                        $em->flush();
		            } else {
		            	$lineStock = new LineStock();
		            	$lineStock->setLinePurchase($linePurchase);
		            	$lineStock->setQtyUpdate($linePurchase->getQuantityDelivred()+$linePurchase->getArticle()->getIniQty());
                        $lineStock->setDate(new \DateTime('now'));
		            	$lineStock->setOldQty($linePurchase->getArticle()->getIniQty());
		            	$lineStock->setQuantityAlerte($linePurchase->getArticle()->getMinQty());
                        $lineStock->setProdDate(new \DateTime($linePurchase->getProduction()));
                        $lineStock->setValidDate(new \DateTime($linePurchase->getValidation()));
		            	$lineStock->setReference($linePurchase->getArticle()->getReferenceStock());
                        $lineStock->setUnitPrice($linePurchase->getUnitPrice());
                        $lineStock->setUser($user);

		            	 $lineStock->setStock($stock);
		            	 $em->persist($lineStock);
		            }
	             }
	            $em->persist($purchase);
                $em->flush();
                
                $this->addFlash('success', "تمت الاضافة بنجاح");
                return $this->redirectToRoute("purchase_index");
            }
        }
        /*$purchases = $em->getRepository(Purchase::class)->findAll();
        $articles = $em->getRepository(Article::class)->findAll();*/
        $id = $this->getUser()->getId();
        $purchases = $em->getRepository(Purchase::class)->findPurchaseByUser($id);
        $articles = $em->getRepository(Article::class)->findArticleByUser($id);
        return $this->render('purchase/purchase.html.twig', array(
            'form' => $form->createView(),
            'purchases' => $purchases,
            'articles' => $articles,
           // 'linePurchases' => $linePurchase,
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
     * @Route("/{id}/edit", name="purchase_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Purchase $purchase, PurchaseService $purchaseService, LinePurchaseService $linePurchaseService, LineStockService $lineStockService): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(PurchaseEditType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /* ------ calcul du prix total de chaque line_purchase -------*/

            foreach ($purchase->getLinePurchases() as $linePurchase) {
                $linePurchase->setTotalPrice($linePurchaseService->calculPrice($linePurchase));        
                $linePurchase->setPurchase($purchase);
            }
               /* ------ calcul du prix total de chaque purchase -------*/
            $purchase->setTotalPrice($purchaseService->calculTotalPrice($purchase));
  
            //  faire mise à jour du stock:
            foreach ($purchase->getLinePurchases() as $linePurchase) {
                $myStock= $lineStockService->newStock($linePurchase);
                // if ($myStock) {
                    /* unit price */
                    $myStock->setUnitPrice($linePurchase->getUnitPrice());
                    $myStock->setProdDate(new \DateTime($linePurchase->getProduction()));
                    $myStock->setValidDate(new \DateTime($linePurchase->getValidation()));

                    $old_quantity = $myStock->getOldQty();
                    $quantity = $linePurchase->getQuantityDelivred();
                    $myStock->setQtyUpdate($old_quantity + $quantity);
                    $em->flush();
                // } else {
                //     $lineStock = new LineStock();
                //     $lineStock->setLinePurchase($linePurchase);
                //     $lineStock->setQtyUpdate($linePurchase->getQuantityDelivred()+$linePurchase->getArticle()->getIniQty());
                //     $lineStock->setOldQty($linePurchase->getArticle()->getIniQty());
                //     $lineStock->setQuantityAlerte($linePurchase->getArticle()->getMinQty());
                //     $lineStock->setProdDate(new \DateTime($linePurchase->getProduction()));
                //     $lineStock->setValidDate(new \DateTime($linePurchase->getValidation()));
                //     $lineStock->setReference($linePurchase->getArticle()->getReferenceStock());
                //     $lineStock->setUnitPrice($linePurchase->getUnitPrice());

                //     $lineStock->setStock($stock);
                //     $em->persist($lineStock);
                // }
            }
            $em->persist($purchase);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('purchase_index');
        }

        return $this->render('purchase/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
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
       // return new Response(1);

        return $this->redirectToRoute('purchase_index');
    }
    /**
     * @Route("/pdf/{id}", name="purchase_pdf")
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
        $footer = $this->renderView('pdf/footer.html.twig', array(
            'institution'=> $institution,
        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        // Write some HTML code:
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
    /**
     * * @Route("/receive/{id}", name="receive_pdf")
     *
     */

    public function receive($id)
    { $purchases =$this->getDoctrine()
        ->getRepository(Purchase::class)->findPurchaseByUser($this->getUser()->getId());

        $linePurchase=$this->getDoctrine()
            ->getRepository(LinePurchase::class)
            ->findLinePurchaseByPurchase($id);

        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)
            ->findInstitutionByUser($this->getUser()->getId());

        $commission= $this->getDoctrine()
            ->getRepository(Commission::class)->findCommissionByUser($this->getUser()->getId());
        $html = $this->renderView('pdf/receive.html.twig', array(
            'purchases' => $purchases,
            'line_purchases' => $linePurchase,
            'title' =>"محضر جلسة استلام المواد",
           'commissions'=>$commission,
           'institution'=> $institution,
        ));
        $footer = $this->renderView('pdf/footer.html.twig', array(
            'institution'=> $institution,
        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        $mpdf->SetHTMLFooter($footer);
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
}