<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Entity\LineInventory;
use App\Entity\LineStock;
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
            // return $this->redirectToRoute('inventory_show');
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
        $lineStock= new LineStock();
      //  foreach ($inventory->getLineInventories() as $lineInventory) {

          //  $lineInventory->setQtyTh($lineInventory->getLineStock()->getQtyUpdate);
         //  $lineInventory->setInventory($Inventory);
             // find Line Stock By Article:
            //   $repositoryLineStock = $this->getDoctrine()->getRepository(LineStock::class);
            //  $repositoryLineInventory = $this->getDoctrine()->getRepository(LineInventory::class);
            //  $findLineStockByArticle = $repositoryLineStock->findOneBy(['article' => $lineStock->getLinePurchase()->getArticle()]);
            //  $findLineInventoryByLineStock = $repositoryLineInventory->findOneBy(['line_stock' => $findLineStockByArticle]); 


       // $QtyTh=$findLineInventoryByLineStock->setQtyTh($findLineStockByArticle->getQtyUpdate());
// persist($lineStock);
      //  }
        // foreach ($inventory->getLineInventories() as $lineInventory)

        // {  $id = $lineInventory->getId();}
        //   $lineStock=$this->getDoctrine()
        //     ->getRepository(LineStock::class)
        //     ->findLineStockByLineInventory($id);
           

     //  dump($inventory);die();
        return $this->render('inventory/show.html.twig', [
            'inventory' => $inventory,
            // 'lineStocks' => $lineStock,
            //'QtyTh' => $QtyTh,
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
        /*$lineStock=$this->getDoctrine()
            ->getRepository(LineStock::class)
            ->findLineStockByLineInventory($id);*/
        return $this->render('inventory/edit.html.twig', [
            'inventory' => $inventory,
            'form' => $form->createView(),
          //  'lineStocks'=> $lineStock,
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
}
