<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Entity\LineRequestSupplied;
use App\Form\LineRequestSuppliedType;
use App\Repository\LineRequestSuppliedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/line/request/supplied")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class LineRequestSuppliedController extends AbstractController
{
    /**
     * @Route("/", name="line_requestSupplied_index", methods={"GET"})
     */
    public function index(LineRequestSuppliedRepository $lineRequestSuppliedRepository): Response
    {
        return $this->render('line_request_supplied/index.html.twig', [
            'line_requestSupplieds' => $lineRequestSuppliedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="line_requestSupplied_new", methods={"GET","POST"})
     */

    public function new(Request $request): Response
    {
        $lineRequestSupplied = new LineRequestSupplied();
        $form = $this->createForm(LineRequestSuppliedType::class, $lineRequestSupplied);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lineRequestSupplied);
            $entityManager->flush();

            return $this->redirectToRoute('line_requestSupplied_index');
        }

        return $this->render('line_request_supplied/new.html.twig', [
            'line_requestSupplieds' => $lineRequestSupplied,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/detail/{id}", name="lineRequestSupplied_detail")
     *
     */
    public function detail( $id)
    {
        $lineRequestSupplied =$this ->getDoctrine()
                                   ->getRepository(LineRequestSupplied::class)
                                   ->findLineRequestSuppliedByRequestSupplied($id);


          /*var_dump($lineRequestSupplied);
          die();*/
        return $this->render('line_request_supplied/detail.html.twig', array(
            'lineRequestSupplieds' => $lineRequestSupplied,
        ));
    }

    /**
     * @Route("/pdf/request/{id}", name="request_supplied_pdf")
     *
     */
    /*public function request( $id)
    {
        $lineRequestSupplied=$this->getDoctrine()
            ->getRepository(LineRequestSupplied::class)
            ->findLineRequestSuppliedByRequestSupplied($id);
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/request.html.twig', array(
            // 'form' => $form->createView(),
            'lineRequestSupplieds' => $lineRequestSupplied,
            // 'exitts' => $exitt,
            'title' =>"طلب تزوّد",
            'institution'=> $institution,
        ));

        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }*/

}
