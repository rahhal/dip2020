<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/budget")
 */
class BudgetController extends AbstractController
{
    /**
     * @Route("/", name="budget_index", methods={"GET"})
     */
    public function index(BudgetRepository $budgetRepository): Response
    {
        return $this->render('budget/index.html.twig', [
            'budgets' => $budgetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="budget_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $budget = new Budget();
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($budget);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'تمت الاضافة بنجاح!'
            );

            return $this->redirectToRoute('budget_index');
        }

        return $this->render('budget/new.html.twig', [
            'budget' => $budget,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="budget_show", methods={"GET"})
     */
    public function show(Budget $budget): Response
    {
        return $this->render('budget/show.html.twig', [
            'budget' => $budget,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="budget_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Budget $budget): Response
    {
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            $this->addFlash('success', "تم التعديل بنجاح");
            return $this->redirectToRoute('budget_index');
        }

        return $this->render('budget/edit.html.twig', [
            'budget' => $budget,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="budget_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Budget $budget): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budget->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($budget);
            $entityManager->flush();
        }
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('budget_index');
    }
}
