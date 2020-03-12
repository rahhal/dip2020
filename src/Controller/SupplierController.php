<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Entity\Institution;
use App\Form\SupplierType;
use App\Repository\SupplierRepository;
use App\Repository\InstitutionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/supplier")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class SupplierController extends AbstractController
{
    /**
     * @Route("/new", name="supplier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {    $entityManager = $this->getDoctrine()->getManager();

        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirectToRoute('supplier_new');
        }
$suppliers=$entityManager->getRepository(Supplier::class)->findAll();
        return $this->render('supplier/supplier.html.twig', [
            'suppliers' => $suppliers,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="supplier_show", methods={"GET"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function show(Supplier $supplier): Response
    {
        return $this->render('supplier/show.html.twig', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="supplier_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function edit(Request $request, Supplier $supplier): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "تم التعديل بنجاح");
            return $this->redirectToRoute('supplier_new');
        }
        return $this->render('supplier/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="supplier_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function delete(Request $request, Supplier $supplier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($supplier);
            $entityManager->flush();
        }
        $this->addFlash('success', "تم الحذف بنجاح");

        return $this->redirectToRoute('supplier_new');
    }
     /**
     * @Route("/print/suppliers", name="prints_pdf")
     *
     */
    public function print()
    {
        $suppliers = $this->getDoctrine()
            ->getRepository(Supplier::class)
            ->findAll();
        
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/supplier.html.twig', array(
            'suppliers' => $suppliers,
            'title' => "قائمة المزودين",
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
