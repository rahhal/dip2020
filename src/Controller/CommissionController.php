<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Employee;
use App\Entity\Institution;
use App\Repository\EmployeeRepository;
use App\Form\CommissionType;
use App\Repository\CommissionRepository;
use Mpdf\Tag\SetPageFooter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commission")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
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
            $user = $this->getUser();
            $commission->setUser($user);

            $entityManager->persist($commission);
            $entityManager->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirectToRoute('commission_new');
        }
        $id = $this->getUser()->getId();
        $commissions = $em->getRepository(Commission::class)->findCommissionByUser($id);
        $employees=$this->getDoctrine()-> getRepository(Employee::class)
            ->findEmployeeByUser($id);
        return $this->render('commission/commission.html.twig', [
            'commissions' => $commissions,
            'form' => $form->createView(),
            //'employees' => $employees,
        ]);
    }

    /**
     * @Route("/{id}", name="commission_show", methods={"GET"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function show(Commission $commission): Response
    {
        return $this->render('commission/show.html.twig', [
            'commission' => $commission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commission_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
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
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
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
        $id = $this->getUser()->getId();
        $commissions = $this->getDoctrine()->getRepository(Commission::class)
                            ->findCommissionByUser($id);
        $institution=$this->getDoctrine()->getRepository(Institution::class)
                          ->findInstitutionByUser($id);

        $html = $this->renderView('pdf/commission.html.twig', array(
            'title' =>"لجنة قبول المواد",
            'commissions'=>$commissions,
            'institution'=> $institution,
        ));
        $footer = $this->renderView('pdf/footer.html.twig', array(
            'institution'=> $institution,
        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        // Write some HTML code:
        $mpdf->SetHTMLFooter ($footer);
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
}
