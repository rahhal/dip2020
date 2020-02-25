<?php

namespace App\Controller;

use App\Entity\Exitt;
use App\Entity\Institution;
use App\Entity\Journal;
use App\Entity\LineExitt;
use App\Entity\LinePurchase;
use App\Entity\LineStock;
use App\Entity\Menu;
use App\Form\LineExittType;
use App\Repository\LineExittRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



/**
 * @Route("/line/exitt")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class LineExittController extends AbstractController
{
    /**
     * @Route("/", name="line_exitt_index", methods={"GET"})
     */
    public function index(LineExittRepository $lineExittRepository): Response
    {
        return $this->render('line_exitt/index.html.twig', [
            'line_exitts' => $lineExittRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="line_exitt_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lineExitt = new LineExitt();

        $form = $this->createForm(LineExittType::class, $lineExitt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($lineExitt);
            $entityManager->flush();

            return $this->redirectToRoute('line_exitt_index');
        }

        return $this->render('line_exitt/new.html.twig', [
            'line_exitt' => $lineExitt,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="line_exitt_show", methods={"GET"})
     */
    public function show(LineExitt $lineExitt): Response
    {
        return $this->render('line_exitt/show.html.twig', [
            'line_exitt' => $lineExitt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="line_exitt_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LineExitt $lineExitt): Response
    {
        $form = $this->createForm(LineExittType::class, $lineExitt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exitt_show',['id'=>$lineExitt->getExitt()->getId()]);
        }

        return $this->render('line_exitt/edit.html.twig', [
            'line_exitt' => $lineExitt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="line_exitt_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LineExitt $lineExitt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineExitt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lineExitt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_exitt_index');
    }

    /**
     * @Route("/pdf/{id}", name="exitt_pdf")
     *
     */
    public function pdf( $id)
    {
        $lineExitt=$this->getDoctrine()
              ->getRepository(LineExitt::class)
              ->findLineExittByExitt($id);
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

	    $html = $this->renderView('pdf/exitt.html.twig', array(
            // 'form' => $form->createView(),
            'line_exitts' => $lineExitt,
           // 'exitts' => $exitt,
            'title' =>"وصل خروج",
            'institution'=> $institution,
        ));
        $footer = $this->renderView('pdf/footer.html.twig', array(
            'institution'=> $institution,
        ));
	    // Create an instance of the class:
	    $mpdf = new \Mpdf\Mpdf();
	    $mpdf->SetDirectionality('rtl');
	    // Write some HTML code:
        $mpdf->SetHTMLFooter($footer);
	    $mpdf->WriteHTML($html);
	    // Output a PDF file directly to the browser
	    $mpdf->Output();
    }
    /**
     * @Route("/permit/{id}", name="exitt_permit")
     *
     */
    public function permit($id)
    {

     $exitt = $this->getDoctrine()
            ->getRepository(Exitt::class)
            ->find($id);

     $line_exitt = $exitt->getLineExitts();

	    $line_stock = null;
	    $date = null;
     foreach ($line_exitt as $item) {
	     $line_stock = $item->getLineStocks();
     }
     //dump($line_stock);die();
     $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();
	    $date = $exitt->getDate();
	    $d = date_format($date, 'l');
	    $menu = $this->getDoctrine()
				->getRepository(Menu::class)
				->findBy(['day' => $d]);

        $html = $this->renderView('pdf/permit.html.twig', array(
            // 'form' => $form->createView(),
            'line_exitts' => $line_exitt,
            'line_stocks' => $line_stock,
            'title' =>"إذن وقتي ",
            'institution'=> $institution,
            'menus'=> $menu,
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
