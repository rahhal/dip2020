<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Institution;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\InstitutionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
            $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirectToRoute('article_new');
        }
        $articles = $em->getRepository(Article::class)->findAll();
        return $this->render('article/article.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function edit($id= null, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
            $article = $em->find(Article::class, $id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('article_new');
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
    * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function show($id): Response
    {
        /*if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }*/
        $em= $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        // dump($article);die;

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('article_new');
    }

    /**
     * check Reference Existance
     *
     * @Route("/articles/check_reference", name="reference_check_validity")
     */
    public function checkReferenceValidityAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reference_stock=$request->get('reference_stock');
        $article= $em->getRepository(Article::class)->findOneBy(['reference_stock' => $reference_stock]);
        if($article){
            $response = new Response(
                'exist',
                Response::HTTP_OK,
                ['content-type' => 'text/plain']
            );
        }else{
            $response = new Response(
                'not_exist',
                Response::HTTP_OK,
                ['content-type' => 'text/plain']
            );
        }

        return $response;
    }
     /**
     * @Route("/print/articles", name="printa_pdf")
     *
     */
    public function print()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        
        $institution=$this->getDoctrine()
            ->getRepository(Institution::class)->findAll();

        $html = $this->renderView('pdf/article.html.twig', array(
            'articles' => $articles,
            'title' => "قائمة المواد",
            'institution'=> $institution,
        ));
        $footer = $this->renderView('pdf/footer.html.twig', array(
            'institution'=> $institution,
        ));
       
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        $mpdf->SetHTMLFooter($footer);
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
}
