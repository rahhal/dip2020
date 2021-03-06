<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class MenuController extends AbstractController
{

    /**
     * @Route("/new", name="menu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {$em = $entityManager = $this->getDoctrine()->getManager();
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $menu->setUser($user);
            $em ->persist($menu);
            $em ->flush();
            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirectToRoute('menu_new');
        }
       // $menus = $em->getRepository(Menu::class)->findAll();
        $id = $this->getUser()->getId();
        $menus = $em->getRepository(Menu::class)->findMenuByUser($id);
        return $this->render('menu/menu.html.twig', [
            'menus' => $menus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_show", methods={"GET"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="menu_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function edit(Request $request, Menu $menu): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('menu_new');
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function delete(Request $request, Menu $menu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($menu);
            $entityManager->flush();
        }
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('menu_new');
    }
}
