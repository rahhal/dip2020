<?php

namespace App\Controller;

use App\Entity\LineInventory;
use App\Form\LineInventoryType;
use App\Repository\LineInventoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/line/inventory")
 */
class LineInventoryController extends AbstractController
{
    /**
     * @Route("/", name="line_inventory_index", methods={"GET"})
     */
    public function index(LineInventoryRepository $lineInventoryRepository): Response
    {
        return $this->render('line_inventory/index.html.twig', [
            'line_inventories' => $lineInventoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="line_inventory_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id): Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $lineInventory = new LineInventory();
        $inventory=$entityManager->getRepository('App:Inventory')->find($id);

        $form = $this->createForm(LineInventoryType::class, $lineInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lineInventory->setInventory($inventory);
            $entityManager->persist($lineInventory);
            $entityManager->flush();

            return $this->redirectToRoute('inventory_show',array('id'=>$inventory->getId()));
        }

        return $this->render('line_inventory/new.html.twig', [
            'line_inventory' => $lineInventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="line_inventory_show", methods={"GET"})
     */
    public function show(LineInventory $lineInventory): Response
    {
        return $this->render('line_inventory/show.html.twig', [
            'line_inventory' => $lineInventory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="line_inventory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LineInventory $lineInventory): Response
    {
        $form = $this->createForm(LineInventoryType::class, $lineInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('line_inventory_index');
        }

        return $this->render('line_inventory/edit.html.twig', [
            'line_inventory' => $lineInventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="line_inventory_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LineInventory $lineInventory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineInventory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lineInventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_inventory_index');
    }
}
