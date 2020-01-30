<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Institution;
use App\Entity\LinePurchase;
use App\Entity\LineStock;
use App\Form\LineStockType;
use App\Repository\LineStockRepository;
use App\Repository\LinePurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/line/stock")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class LineStockController extends AbstractController
{
    /**
     * @Route("/", name="line_stock_index", methods={"GET"})
     */
    public function index(LineStockRepository $lineStockRepository): Response
    {
        $line_purchases = $this->getDoctrine()->getRepository(LinePurchase::class)->findAll();
        return $this->render('line_stock/index.html.twig', [
            'line_stocks' => $lineStockRepository->findAll(),
            'line_purchases' => $line_purchases,
        ]);
    }
    /**
     * @Route("/stockinitial", name="line_stock_stocki", methods={"GET"})
     */
    public function stockinitial(Request $request): Response
    {
        // $em = $this->getDoctrine()->getManager();
        $articles=$this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

       // var_dump($article);die();
        // $stck_ini= $em->getRepository(Article::class)->stockIni();
        return $this->render('line_stock/stckIni.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/stockvalid", name="line_stock_valid", methods={"GET"})
     */
    public function stockvalid(Request $request): Response
    {
        $lineStocks=$this->getDoctrine()
            ->getRepository(LineStock::class)
            ->findAll();
        return $this->render('line_stock/stckvalid.html.twig', [
            'lineStocks' => $lineStocks,
        ]);
    }
    /**
     * @Route("/new", name="line_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lineStock = new lineStock();
        $form = $this->createForm(LineStockType::class, $lineStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lineStock);
            $entityManager->flush();

            return $this->redirectToRoute('line_stock_index');
        }
        return $this->render('line_stock/new.html.twig', [
            'line_stock' => $lineStock,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="line_stock_show", methods={"GET"})
     */
    public function show(lineStock $lineStock): Response
    {
        return $this->render('line_stock/show.html.twig', [
            'line_stock' => $lineStock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="line_stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, lineStock $lineStock): Response
    {
        $form = $this->createForm(LineStockType::class, $lineStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('line_stock_index');
        }

        return $this->render('line_stock/edit.html.twig', [
            'line_stock' => $lineStock,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="line_stock_delete", methods={"DELETE"})
     */
    public function delete(Request $request, lineStock $lineStock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineStock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lineStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_stock_index');
    }


    /**
     * @Route("/pdf/line_stock", name="line_stock_pdf")
     *
     */

    public function pdf()
    {
        $lineStock= $this->getDoctrine()
            ->getRepository(LineStock::class)->findAll();
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();
        $html = $this->renderView('pdf/stock.html.twig', array(
            'title' =>"محتويات المخزن",
            'lineStocks'=> $lineStock,
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
     * @Route("/printv/line_stock", name="valid_pdf")
     *
     */

    public function printv()
    {
        $lineStock= $this->getDoctrine()
            ->getRepository(LineStock::class)->findAll();
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/stk_valid.html.twig', array(
            'title' =>"صلحية المواد",
            'lineStocks'=> $lineStock,
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
