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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/journal")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class JournalController extends AbstractController
{
    /**
     * @Route("/", name="journal_index", methods={"GET"})
     */
    public function index(JournalRepository $journalRepository, $id=null)
    {
        $exitt=$this->getDoctrine()
            ->getRepository(Exitt::class)
            ->findExittByJournal($id);
        $nbMeal = $this->getDoctrine()
            ->getRepository(NbMeal::class)
            ->findNbMealtByJournal($id);
        return $this->render('journal/index.html.twig', [
            'journals' => $journalRepository->findAll(),
            'exitts'=> $exitt,
            'nbMeals' => $nbMeal,
        ]);
    }
    /**
     * @Route("/ajout/journal", name="ajout-journal")
     * @Route("/new", name="journal_new", methods={"GET","POST"})
     */

    public function journal( Request $request, $id=null)
    {
        $journal = new Journal();
        $exitt = new  Exitt();
        $nbMeal = new NbMeal();
        $form = $this->createForm(JournalType::class, $journal);
        $form->handleRequest($request);

        /*  calcul du prix total au journal */
        foreach ($exitt->getJournals() as $journal)
        { $journal->setTotalCosts($exitt->getTotalPrice());}
        foreach ($nbMeal->getJournals() as $journal)
        {$journal->setTotalMeals($nbMeal->getStdSemiResident()+ $nbMeal->getStdResident()+ $nbMeal->getStdGranted()+ $nbMeal->getCurators() +$nbMeal->getProfessor());
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /*  calcul du prix total au journal   */

            /*foreach ($exitt->getJournals() as $journal)
            { $journal->setTotalCosts($exitt->getTotalPrice());}*/

            /*foreach ($nbMeal->getJournals() as $journal)
            {$journal->setTotalMeals($nbMeal->getStdSemiResident()+ $nbMeal->getStdResident()+ $nbMeal->getStdGranted()+ $nbMeal->getCurators() +$nbMeal->getProfessor());
            }

            /*  calcul du plat   */

            /*if ($journal->getTotalMeals() != 0)
                $journal->setUnitCost($exitt->getTotalPrice() / $journal->getTotalMeals());
            else
                throw new NotFoundHttpException("impossible,division par zero");*/
            /*  calcul du plat   */
            /* if ($journal->getTotalMeals()!= 0)
              $journal->setUnitCost($exitt->getTotalPrice() / $journal->getTotalMeals());
             else
               return "impossible,division par zero";*/

            /*================== */
            /*foreach ($nbMeal->getJournals() as $journal)
            { //$date = $journal->getDate();
            //$nbMeal = $this->getDoctrine()->getRepository(NbMeal::class)->findOneBy(['date'=>$date]);
            $totalMeals=$nbMeal->getStdSemiResident() + $nbMeal->getStdResident() + $nbMeal->getStdGranted() + $nbMeal->getCurators() + $nbMeal->getProfessor();
            $journal->setTotalMeals($totalMeals);}*/
/* =================== */


//dump($journal);die;
            $entityManager->persist($exitt);
            $entityManager->persist($nbMeal);
            $entityManager->persist($journal);
            $entityManager->flush();

            return $this->redirectToRoute('journal_index');
        }


        // $journal->getLineExitt()->getTotalPrice();
        // $lineExitt = $em->getRepository(LineExitt::class)->find($id);
         $exitt=$this->getDoctrine()
             ->getRepository(Exitt::class)
             ->findExittByJournal($id);

        $nbMeal=$this->getDoctrine()
            ->getRepository(NbMeal::class)
            ->findNbMealtByJournal($id);
        // $lineExitts=$em->getRepository(LineExitt::class)->findOneById($id);
        return $this->render('journal/new.html.twig', [
            'journal' => $journal,
            'form' => $form->createView(),
            'exitt' => $exitt,
            'nbMeal'=>$nbMeal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="journal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Journal $journal): Response
    {
        $form = $this->createForm(JournalType::class, $journal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'تمت العملية بنجاح!'
            );
            return $this->redirectToRoute('journal_index');
        }

        return $this->render('journal/edit.html.twig', [
            'journal' => $journal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="journal_show", methods={"GET"})
     */
    public function show(Journal $journal): Response
    {
        return $this->render('journal/show.html.twig', [
            'journal' => $journal,
        ]);
    }
    /**
     * @Route("/{id}", name="journal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Journal $journal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$journal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($journal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('journal_index');
    }
    /**
     * * @Route("/pdf/journal/{id}", name="journal_pdf")
     *
     */
    public function journalp($id = null)
    {
        $exitts =$this->getDoctrine()
            ->getRepository(Exitt::class)->findAll();

        $lineExitt=$this->getDoctrine()
            ->getRepository(LineExitt::class)
            ->findLineExittByJournal($id);
        $menu=$this->getDoctrine()
            ->getRepository(Menu::class)
            ->findMenutByJournal($id);


        //var_dump($lineExitt);die();

        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $nbMeal=$this->getDoctrine()
            ->getRepository(NbMeal::class)->NbMealtByJournal($id);
        $commission= $this->getDoctrine()
            ->getRepository(Commission::class)->findAll();
        $html = $this->renderView('pdf/journal.html.twig', array(
            'exitts' => $exitts,
            'lineExitts' => $lineExitt,
            'title' =>"التقرير اليومي للاكلة",
            'menus'=>$menu,
            'nbMeals'=>$nbMeal,
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
