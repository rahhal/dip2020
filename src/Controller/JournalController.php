<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Exitt;
use App\Entity\Institution;
use App\Entity\Journal;
use App\Entity\LineExitt;
use App\Entity\Menu;
use App\Entity\NbMeal;
use App\Form\JournalType;
use App\Repository\JournalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/journal")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class JournalController extends AbstractController
{
    /**
     * @Route("/new", name="journal_new", methods={"GET","POST"})
     */

    public function journal( Request $request, $id=null)
    {
        $journal = new Journal();
         $nbMeal = new NbMeal();
        //die();
        $em =$entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(JournalType::class, $journal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($form->getData());
            // die();
            /* ------- calcul du plat (unitCost)-------  */
            $nbMeal= $journal->getNbMeal();
            $exitt = $journal ->getExitt();
            $journal->setTotalCosts(floatval($exitt->getTotalPrice()));
            $journal->setTotalMeals($nbMeal->getStdSemiResident() + $nbMeal->getStdResident() + $nbMeal->getStdGranted() + $nbMeal->getCurators() + $nbMeal->getProfessor()+ $nbMeal->getEmployee());
            $tm = $journal->getTotalMeals();
            $tc = $journal->getTotalCosts();
            if ($tm != 0)
                $journal->setUnitCost($tc / $tm);
            else
                throw new NotFoundHttpException("impossible,division par zero");

            $em->persist($journal);
            $em->flush();

            $this->addFlash('success', 'تمت الاضافة بنجاح!');
            return $this->redirectToRoute('journal_new');
        }
        $nbMeals=$this->getDoctrine()
            ->getRepository(NbMeal::class)
            ->myFindByCurrentDate();
        $exitts=$this->getDoctrine()
            ->getRepository(Exitt::class)
            ->myFindByCurrentDate();
        $journals =$em->getRepository(Journal::class)->findAll();
     return $this->render('journal/journal.html.twig', [
            'journals' => $journals,
            'form' => $form->createView(),
             'exitt' => $exitts,
             'nbMeal'=> $nbMeals,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="journal_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function edit(Request $request, Journal $journal): Response
    {
        $form = $this->createForm(JournalType::class, $journal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'تم التغيير بنجاح!');
            return $this->redirectToRoute('journal_index');
        }

        return $this->render('journal/edit.html.twig', [
            'journal' => $journal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="journal_show", methods={"GET"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function show(Journal $journal): Response
    {
        return $this->render('journal/show.html.twig', [
            'journal' => $journal,
        ]);
    }
    /**
     * @Route("/{id}", name="journal_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function delete(Request $request, Journal $journal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$journal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($journal);

            $this->addFlash('success', 'تم الحذف بنجاح!');
            $entityManager->flush();
        }

        return $this->redirectToRoute('journal_new');
    }
    /**
     * * @Route("/pdf/journal/{id}", name="journal_pdf")
     *
     */
    public function journalp($id = null,Journal $journal)
    {
        $exitts =$this->getDoctrine()
            ->getRepository(Exitt::class)->findAll();

        $lineExitt=$this->getDoctrine()
            ->getRepository(LineExitt::class)
            ->findLineExittByJournal($id);
        $date= $journal->getDate();
        $d=date_format($date, 'l');
        //dump($d);die();
        $menu=$this->getDoctrine()
            ->getRepository(Menu::class)
           ->findBy(['day' => $d]);
        //dump($menu);die();
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();
        $nbMeal=$this->getDoctrine()
            ->getRepository(NbMeal::class)
            ->findBy(['date' => $journal->getDate()]);
        $journal=$this->getDoctrine()
            ->getRepository(Journal::class)
            ->findBy(['date' => $journal->getDate()]);
        $commission= $this->getDoctrine()
            ->getRepository(Commission::class)->findAll();

        $html = $this->renderView('pdf/journal.html.twig', array(
            'exitts' => $exitts,
            'lineExitts' => $lineExitt,
            'title' =>"التقرير اليومي للاكلة",
            'menus'=>$menu,
           'journals' =>$journal,
           'nbMeals'=>$nbMeal,
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
