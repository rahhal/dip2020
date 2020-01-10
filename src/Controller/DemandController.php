<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Entity\LineDemand;
use App\Entity\Article;
use App\Entity\Institution;
use App\Form\DemandType;
use App\Repository\DemandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demand")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class DemandController extends AbstractController
{
    /**
     * @Route("/", name="demand_index", methods={"GET"})
     */
    public function index(DemandRepository $demandRepository): Response
    {
        return $this->render('demand/index.html.twig', [
            'demands' => $demandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="demand_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demand);
            $entityManager->flush();

            return $this->redirectToRoute('demand_show',['id'=>$demand->getId()]);
        }

        return $this->render('demand/new.html.twig', [
            'demand' => $demand,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="demand_show", methods={"GET"})
     */
    public function show(Demand $demand): Response
    {
        return $this->render('demand/show.html.twig', [
            'demand' => $demand,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demand_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Demand $demand): Response
    {
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demand_index');
        }

        return $this->render('demand/edit.html.twig', [
            'demand' => $demand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demand_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Demand $demand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demand_index');
    }
}
