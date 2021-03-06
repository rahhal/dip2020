<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {$em = $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $category->setUser($user);

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");

            return $this->redirectToRoute('category_new');
        }
    
        $categories = $em->getRepository(Category::class)->findCategoryByUser($this->getUser()->getId());
        return $this->render('category/category.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('category_new');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }
        $this->addFlash('success', "تم الحذف بنجاح");

        return $this->redirectToRoute('category_new');
    }
}
