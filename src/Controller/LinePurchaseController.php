<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Entity\LinePurchase;
use App\Entity\Purchase;
use App\Form\LinePurchaseType;
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
 * @Route("/line/purchase")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class LinePurchaseController extends AbstractController
{
    /**
     * @Route("/", name="line_purchase_index", methods={"GET"})
     */
    public function index(LinePurchaseRepository $linePurchaseRepository): Response
    {
        return $this->render('line_purchase/index.html.twig', [
            'line_purchases' => $linePurchaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/commi", name="line_purchase_commi", methods={"GET"})
     */
    public function commi(Request $request): Response
    {
        // $em = $this->getDoctrine()->getManager();
        $line_purchases=$this->getDoctrine()
            ->getRepository(LinePurchase::class)
            ->findAll();

        // var_dump($line_purchases);die();
        return $this->render('line_purchase/commi.html.twig', [
            'line_purchases' => $line_purchases,
        ]);
    }

    /**
     * @Route("/new", name="line_purchase_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $linePurchase = new LinePurchase();
        $form = $this->createForm(LinePurchaseType::class, $linePurchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($linePurchase);
            $entityManager->flush();

           // return $this->redirectToRoute('line_purchase_index');
            return $this->redirectToRoute('purchase_index');
        }

        return $this->render('line_purchase/new.html.twig', [
            'line_purchase' => $linePurchase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/detail/{id}", name="linePurchase_detail")
     *
     */
    public function detail( $id)
    {
        $linePurchase=$this->getDoctrine()
            ->getRepository(LinePurchase::class)
            ->findLinePurchaseByPurchase($id);
        /* $items = $purchase->getLinePurchase();
         foreach ($items  as  $item)
         { Var_dump($items) ;}*/
      /*  var_dump($linePurchase);
        die();*/
        return $this->render('line_purchase/detail.html.twig', array(
            // 'form' => $form->createView(),
            'linePurchases' => $linePurchase,
        ));
    }


    /**
     * @Route("/{id}", name="line_purchase_show", methods={"GET"})
     */
    public function show(LinePurchase $linePurchase): Response
    {
        return $this->render('line_purchase/show.html.twig', [
            'line_purchase' => $linePurchase,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="line_purchase_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LinePurchase $linePurchase): Response
    {   // $linePurchase = new LinePurchase();
         $entityManager = $this->getDoctrine()->getManager();
        // $purchase=$entityManager->getRepository('App:Purchase')->find($id);

        $form = $this->createForm(LinePurchaseType::class, $linePurchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

           /* $linePurchase->setPurchase($purchase);
            $entityManager->persist($linePurchase);*/
            $id= $linePurchase->getPurchase()->getId();
            return $this->redirectToRoute('purchase_show',array('id'=>$id));

        }

        return $this->render('line_purchase/edit.html.twig', [
            'line_purchase' => $linePurchase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="line_purchase_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LinePurchase $linePurchase): Response
    {
        if ($this->isCsrfTokenValid('delete'.$linePurchase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($linePurchase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_purchase_index');
    }

    /**
     * @Route("/pdf/{id}", name="purchase_pdf")
     *
     */
    public function pdf( $id)
    {
     // $em = $this->getDoctrine()->getManager();
        /* if (is_null($id))
             $linePurchase = new LinePurchase();
         else
             $linePurchase = $em->find(LinePurchase::class, $id);

         $oldLinePurchase = new ArrayCollection();
         foreach ($linePurchase->getLinePurchase() as $linePurchase)
             $oldLinePurchase->add($linePurchase);*/
/*
         $linePurchase = $this->getDoctrine()
             ->getRepository(LinePurchase::class)
             ->find($id);
      /*   foreach ($linePurchase->getLinePurchase() as $linePurchase)
             $linePurchase->setPurchase($purchase);*/

         // Retrieve the HTML generated in our twig file
       /*  $html = $this->renderView('pdf/purchase.html.twig', [
             'line_purchases' => "$linePurchase"
         ]);*/
/*
        $linePurchase = $this->getDoctrine()
            ->getRepository(LinePurchase::class)
//            ->find($id);
            ->findLinePurchaseByPurchase($id);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/purchase.html.twig', [
            'line_purchases' => "$linePurchase"
        ]);*/



    }

}
