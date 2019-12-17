<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Institution;
use App\Entity\LineRequestSupplied;
use App\Entity\RequestSupplied;
use App\Form\RequestSuppliedType;
use App\Form\LineRequestSuppliedType;
use App\Repository\RequestSuppliedRepository;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/request/supplied")
 */
class RequestSuppliedController extends AbstractController
{
    /**
     * @Route("/", name="request_supplied_index", methods={"GET"})
     */
    public function index(RequestSuppliedRepository $requestSuppliedRepository)
    {
        return $this->render('request_supplied/index.html.twig', [
            'requestSupplieds' => $requestSuppliedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout/request/supplied", name="ajout-request_supplied")
     * @Route("/modifier/request/supplied/{id}", name="modifier-request_supplied" )
     * @Route("/new", name="request_supplied_new")
     *
     */
    public  function requestSupplied($id=null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $requestSupplied = new RequestSupplied();
        else
            $requestSupplied = $em->find(RequestSupplied::class, $id);
        $form = $this->createForm(RequestSuppliedType::class, $requestSupplied);

        $oldLineRequestSupplied = new ArrayCollection();

        foreach ($requestSupplied->getLineRequestSupplieds() as $lineRequestSupplied)
            $oldLineRequestSupplied->add($lineRequestSupplied);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
                foreach ($oldLineRequestSupplied as $lineRequestSupplied)
                    if (false === $requestSupplied->getLineRequestSupplieds()->contains($lineRequestSupplied))
                        $em->remove($lineRequestSupplied);

                foreach ($requestSupplied->getLineRequestSupplieds() as $lineRequestSupplied)
                    $lineRequestSupplied->setRequestSupplieds($requestSupplied);
                $em->persist($requestSupplied);
                $em->flush();

                dump($requestSupplied);
                die();

                $this->addFlash('success', "تمت العملية بنجاح");
                return $this->redirectToRoute("request_supplied_index");
            }
        }
        //$requestSupplieds=$em->getRepository(RequestSupplied::class)->findLine($id);
        $requestSupplieds = $em->getRepository(RequestSupplied::class)->findAll();
        $articles = $em->getRepository(Article::class)->findAll();
        return $this->render('request_supplied/request_supplied.html.twig', array(
            'form' => $form->createView(),
            'requestSupplieds' => $requestSupplieds,
            'articles' => $articles,
        ));
    }

    /**
     * @Route("/ajout/request/supplied", name="ajout-request_supplied")
     * @Route("/modifier/request/supplied/{id}", name="modifier-request_supplied")
     * @Route("/new", name="request_supplied_new")
     *
     */
   /* public function requestSupplied($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
        {
            $requestSupplied = new RequestSupplied();
        }
        else
        {    $purchase = $em->find(RequestSupplied::class, $id);
        }
        $form = $this->createForm(RequestSuppliedType::class, $requestSupplied);
        $oldLineRequestSupplied = new ArrayCollection();
        foreach ($requestSupplied->getLineRequestSupplieds() as $lineRequestSupplied)
            $oldLineRequestSupplied->add($lineRequestSupplied);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
                foreach ($oldLineRequestSupplied as $lineRequestSupplied)
                    if (false === $requestSupplied->getLineRequestSupplieds()->contains($lineRequestSupplied))
                        $em->remove($lineRequestSupplied);

                $em->persist($requestSupplied);

                  //dump($requestSupplied);die();

                $em->flush();

                $this->addFlash('success', "تمت العملية بنجاح");
                return $this->redirectToRoute("request_supplied_index");
            }
        }
        $requestSupplieds = $em->getRepository(RequestSupplied::class)->findAll();
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('request_supplied/request_supplied.html.twig', array(
            'form' => $form->createView(),
            'requestSupplieds' => $requestSupplieds,
            'articles' => $articles,
        ));

    }
*/





        /**
         * @Route("/{id}", name="requestSupplied_show", methods={"GET"})
         */
        public function show(RequestSupplied $requestSupplied): Response
    {
        return $this->render('request_supplied/show.html.twig', [
            'requestSupplied' => $requestSupplied,
        ]);
    }
        /**
         * @Route("/delete/request/supplied/{id}", name="request_supplied_delete")
         *
         */
        public function delete(RequestSupplied $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return new Response(1);
    }



    /**
     * @Route("/print/{id}", name="print_pdf")
     *
     */
    public function print( $id)
    {
        $requestSupplieds = $this->getDoctrine()
            ->getRepository(RequestSupplied::class)
            ->myFindOne($id);
        $lineRequestSupplied=$this->getDoctrine()
            ->getRepository(LineRequestSupplied::class)
            ->findLineRequestSuppliedByRequestSupplied($id);

        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/request.html.twig', array(
            'requestSupplieds' => $requestSupplieds,
            'lineRequestSupplieds' => $lineRequestSupplied,
            'title' => "طلب تزوّد",
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
