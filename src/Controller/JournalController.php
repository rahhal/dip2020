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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/journal")
 */
class JournalController extends AbstractController
{
    /**
     * @Route("/", name="journal_index", methods={"GET"})
     */
    public function index(JournalRepository $journalRepository)
    {
        return $this->render('journal/index.html.twig', [
            'journals' => $journalRepository->findAll(),
        ]);
    }
    /**
     * @Route("/ajout/journal", name="ajout-journal")
     * @Route("/modifier/journal/{id}", name="modifier-journal")
     * @Route("/new", name="journal_new", methods={"GET","POST"})
     */

    public function journal( Request $request)
    {
        $journal = new Journal();
        $exitt = new  Exitt();
        $form = $this->createForm(JournalType::class, $journal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /*  recuperation du prix total au journal   */

            /*foreach ($exitt->getJournals() as $journal)
             $journal->setTotalCosts($exitt->getTotalPrice());*/

            $entityManager->persist($journal);
            $entityManager->flush();

            return $this->redirectToRoute('journal_index');
        }


        // $journal->getLineExitt()->getTotalPrice();
        // $lineExitt = $em->getRepository(LineExitt::class)->find($id);
        /* $lineExitt=$this->getDoctrine()
             ->getRepository(LineExitt::class)
             ->findJournalByLineExitt($id);*/

        // $lineExitts=$em->getRepository(LineExitt::class)->findOneById($id);
        return $this->render('journal/new.html.twig', [
            'journal' => $journal,
            'form' => $form->createView(),
            //'lineExitt' => $lineExitt,
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
