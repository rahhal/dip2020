<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Entity\User;
use App\Form\InstitutionType;
use App\Repository\InstitutionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/institution")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class InstitutionController extends AbstractController
{
    /**
     * @Route("/", name="institution_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $institution = new Institution();
        $form = $this->createForm(InstitutionType::class,$institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $institution->setUser($user);
            $entityManager->persist($institution);
            $entityManager->flush();
            $this->addFlash('success', 'تمت الاضافة بنجاح ');
            // return $this->redirectToRoute('institution_show',array('id'=>$institution->getId()));
            return $this->redirectToRoute('institution_show');

        }

        return $this->render('institution/new.html.twig', [
            'institution' => $institution,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/show", name="institution_show", methods={"GET"})
     */
    public function show( ): Response
    {
       $em= $entityManager = $this->getDoctrine()->getManager();

        $em= $this->getDoctrine()->getManager();
        //$institution = $em->getRepository(Institution::class)->find($id);

        /*$institution = $em->getRepository(Institution::class)
                          ->findInstitutionByUser($this->getUser()->getId());*/
        $institution = $entityManager->getRepository('App:Institution')
                        ->findOneBy(['user' => $this->getUser()->getId()]);
        if ($institution)
            return $this->render('institution/show.html.twig', [
                'institution' => $institution,
            ]);
        else
            return $this->redirectToRoute('institution_new');

    }

    /**
     * @Route("/{id}/edit", name="institution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Institution $institution): Response
    {  /*$form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
           $institution->setUser($user);
           // $entityManager->persist($institution);
            dump($user);die();
           // $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('institution_show');
        }

        return $this->render('institution/edit.html.twig', [
                    'institution' => $institution,
                    'form' => $form->createView(),
        ]);*/
       // $em = $this->getDoctrine()->getManager();
       // $institution = $em->find(Institution::class, $id);
        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $entityManager = $this->getDoctrine()->getManager();
            /*$user = $this->getUser();
            $institution->setUser($user);*/
           // dump($institution); die();
            $entityManager->persist($institution);
            $entityManager->flush();

            $this->addFlash('success', "تم التغيير بنجاح");
            return $this->redirectToRoute('institution_show');
        }
        return $this->render('institution/edit.html.twig', [
            'institution' => $institution,
            'form' => $form->createView(),
        ]);
    }
}
