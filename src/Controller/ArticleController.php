<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        /*-------la direction au page login en cas de non authentification------
         if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }*/
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
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
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        /*  redirection to login page */
       /* if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }*/
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
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
        return $this->redirectToRoute('article_index');
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
}
