<?php

namespace App\Controller;

use App\Entity\LineDemand;
use App\Form\LineDemandType;
use App\Repository\LineDemandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/line/demand")
 */
class LineDemandController extends AbstractController
{
    /**
     * @Route("/", name="line_demand_index", methods={"GET"})
     */
    public function index(LineDemandRepository $lineDemandRepository): Response
    {
        return $this->render('line_demand/index.html.twig', [
            'line_demands' => $lineDemandRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{id}/new", name="line_demand_new", methods={"GET","POST"})
     */
    public function new($id, Request $request): Response
    {
        $lineDemand = new LineDemand();

        $entityManager = $this->getDoctrine()->getManager();
        $demand=$entityManager->getRepository('App:Demand')->find($id);

        $form = $this->createForm(LineDemandType::class, $lineDemand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $lineDemand->setDemand($demand);

            $entityManager->persist($lineDemand);
            $entityManager->flush();
            $this->addFlash('success', 'تمت الاضافة بنجاح ');
            return $this->redirectToRoute('demand_show',['id'=>$demand->getId()]);
        }

        return $this->render('line_demand/new.html.twig', [
            'line_demand' => $lineDemand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="line_demand_show", methods={"GET"})
     */
    public function show(LineDemand $lineDemand): Response
    {
        return $this->render('line_demand/show.html.twig', [
            'line_demand' => $lineDemand,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="line_demand_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LineDemand $lineDemand): Response
    {
        $form = $this->createForm(LineDemandType::class, $lineDemand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demand_show',['id'=>$lineDemand->getDemand()->getId()]);
        }

        return $this->render('line_demand/edit.html.twig', [
            'line_demand' => $lineDemand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="line_demand_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LineDemand $lineDemand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineDemand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lineDemand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_demand_index');
    }
}
