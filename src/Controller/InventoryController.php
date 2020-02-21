<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Entity\LineInventory;
use App\Entity\LineStock;
use App\Entity\Institution;
use App\Form\InventoryType;
use App\Repository\InventoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inventory")
 */
class InventoryController extends AbstractController
{
    /**
     * @Route("/", name="inventory_index", methods={"GET"})
     */
    public function index(InventoryRepository $inventoryRepository): Response
    {
        return $this->render('inventory/index.html.twig', [
            'inventories' => $inventoryRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="inventory_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $inventory = new Inventory();
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($inventory);
            $entityManager->flush();

            return $this->redirectToRoute('inventory_show',array('id'=>$inventory->getId()));
        }

        return $this->render('inventory/new.html.twig', [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inventory_show", methods={"GET"})
     */
    public function show(Inventory $inventory): Response
    {
        return $this->render('inventory/show.html.twig', [
            'inventory' => $inventory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inventory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inventory $inventory, $id): Response
    {
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inventory_index');
        }
        return $this->render('inventory/edit.html.twig', [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inventory_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inventory $inventory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inventory_index');
    }

     /**
     * @Route("/pdf/{id}", name="inventory_pdf")
     *
     */
     public function pdf($id = null)
     { $inventories= $this->getDoctrine()->getRepository(Inventory::class)->findAll();
        
        $lineInventories=$this->getDoctrine()
        ->getRepository(LineInventory::class)
        ->findLineInventoryByInventory($id);
        
        $institution=$this->getDoctrine()
             ->getRepository(Institution::class)->findAll();
         $html = $this->renderView('pdf/inventory.html.twig', array(
             'lineInventories' => $lineInventories,
             'title' => "بطاقة جرد",
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
