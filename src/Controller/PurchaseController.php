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
            $lineStock = new LineStock();
            $stock = new stock();
            //$article = new Article();
        }
        else
        {    $purchase = $em->find(Purchase::class, $id);
        }
        $form = $this->createForm(PurchaseType::class, $purchase);
        $oldLinePurchase = new ArrayCollection();
        foreach ($purchase->getLinePurchases() as $linePurchase)
            $oldLinePurchase->add($linePurchase);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
                foreach ($oldLinePurchase as $linePurchase)
                    if (false === $purchase->getLinePurchases()->contains($linePurchase))
                        $em->remove($linePurchase);


                /* ----  calcul du prix total de chaque line_purchase    ------*/
                foreach ($purchase->getLinePurchases() as $linePurchase)
                    $linePurchase->setTotalPrice($linePurchase->getQuantityDelivred()*$linePurchase->getUnitPrice()*(1+($linePurchase->getTax()/ 100)));

                /* ------ calcul du prix total de chaque purchase -------*/

                   $totalPrice=0;
                   foreach ($purchase->getLinePurchases() as $linePurchase)
                   {
                       $totalPrice += $linePurchase->getTotalPrice();
                   }
                   $purchase->setTotalPrice($totalPrice);


                /* insertion des données dans le stock */

                $stock->setName('magasin');
                $linePurchase = new ArrayCollection();

                /*$purchase=$this->getDoctrine()
                    ->getRepository(Purchase::class)
                   ->getPurchaseFromDate($max = 5);*/

                $linePurchase=$this->getDoctrine()
                    ->getRepository(LinePurchase::class)
                    ->findLinePurchaseByPurchase($id);

               // $article-> setName($article);
              foreach ($purchase->getLinePurchases() as $linePurchase)
                    $linePurchase->setPurchase($purchase);

                foreach ($stock->getLineStocks() as $lineStock)
                    $lineStock->getLinePurchases($linePurchase);

                $lineStock->setLinePurchase($linePurchase);

                foreach ($purchase->getLinePurchases() as $linePurchase)
                {
                    $lineStock->setQtyUpdate($linePurchase->getQuantityDelivred()+$linePurchase->getArticle()->getIniQty());
                //  $lineStock->setDate($purchase->getDate());
                $lineStock->setDate(new \DateTime('now'));
                $lineStock->setOldQty($linePurchase->getArticle()->getIniQty());
                $lineStock->setQuantityAlerte($linePurchase->getArticle()->getMinQty());
                $lineStock->setProdDate(new \DateTime('now'));
                $lineStock->setValidDate(new \DateTime('now'));

                /*$lineStock->setProdDate($linePurchase->getProduction());
                $lineStock->setValidDate($linePurchase->getValidation());*/

                $lineStock->setReference($linePurchase->getArticle()->getReferenceStock());
                $lineStock->setStock($stock);
                }

                $em->persist($stock);
                $em->persist($purchase);
              //  $em->persist($article);
                $em->persist($lineStock);

              //  dump($purchase);
               // die();

                $em->flush();
               /* dump($purchase);die();*/

                $this->addFlash('success', "تمت العملية بنجاح");
                return $this->redirectToRoute("purchase_index");
            }
        }
        //$Purchases=$em->getRepository(Purchase::class)->findLine($id);
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
     * @Route("/{id}, name="detail_purchase")
     */
    /*
        public function detail($id )
        {     $em = $this->getDoctrine()->getManager();
              $purchases=$em->getRepository(Purchase::class)->findLine($id);
            return $this->render('purchase/detail.html.twig', array(
               // 'form' => $form->createView(),
                'purchases' => $purchases,
            ));
        }*/
    /**
     * @Route("/detail/{id}", name="purchase_detail")
     *
     */
    /* public function detail( $id)
     {
         $purchase=$this->getDoctrine()
                      ->getRepository(Purchase::class)
                       ->findLinePurchaseByPurchase($id);
        /* $items = $purchase->getLinePurchase();
         foreach ($items  as  $item)
         { Var_dump($items) ;}*/
    // var_dump($purchase);
    //   die();*/
    /*return $this->render('purchase/detail.html.twig', array(
        // 'form' => $form->createView(),
        'purchases' => $purchase,
    ));*/
    // }
    /* public function showById($id)
     {
         $purchase = $this->getDoctrine()
                          ->getRepository(Purchase::class)
                          ->find($id);
         $items = $purchase->getLinePurchase();
          foreach ($items  as  $item)
         { Var_dump($items) ;}
     }*/
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
        return new Response(1);
    }

    /**
     * @Route("/pdf/purchase/{id}", name="purchase_pdf")
     *
     */

    public function pdf($id = null)
    {
        /*$purchases =$this->getDoctrine()
            ->getRepository(Purchase::class)->findAll();*/
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


	   /*

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/purchase.html.twig', [
            'title' => $purchase->getNumber(),
	        'instution' => $institusion
        ]); */

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