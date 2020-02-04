<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Employee;
use App\Entity\Institution;
use App\Repository\EmployeeRepository;
use App\Form\CommissionType;
use App\Repository\CommissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commission")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class CommissionController extends AbstractController
{

    /**
     * @Route("/new", name="commission_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {   $em= $entityManager = $this->getDoctrine()->getManager();
        $commission = new Commission();
        $form = $this->createForm(CommissionType::class, $commission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($commission);
            $entityManager->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirectToRoute('commission_new');
        }
        $commissions = $em->getRepository(Commission::class)->findAll();
        $employees=$this->getDoctrine()
            ->getRepository(Employee::class)
            ->findAll();
        return $this->render('commission/commission.html.twig', [
            'commissions' => $commissions,
            'form' => $form->createView(),
            'employees' => $employees,
        ]);
    }

    /**
     * @Route("/{id}", name="commission_show", methods={"GET"})
     */
    public function show(Commission $commission): Response
    {
        return $this->render('commission/show.html.twig', [
            'commission' => $commission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commission_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commission $commission): Response
    {
        $form = $this->createForm(CommissionType::class, $commission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "تم التغيير بنجاح");

            return $this->redirectToRoute('commission_new');
        }

        return $this->render('commission/edit.html.twig', [
            'commission' => $commission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commission_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commission $commission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commission);
            $entityManager->flush();
        }
        $this->addFlash('success', "تم الحذف بنجاح");

        return $this->redirectToRoute('commission_new');
    }

    /**
     * @Route("/printc/commission", name="commission_pdf")
     *
     */

    public function printc()
    {
        $commission=$this->getDoctrine()
        ->getRepository(Commission::class)
        ->findAll();
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/commission.html.twig', array(
            'title' =>"لجنة قبول المواد",
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
