<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Form\InstitutionType;
use App\Repository\InstitutionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/institution")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class InstitutionController extends AbstractController
{
    /**
     * @Route("/", name="institution_show", methods={"GET"})
     */
    public function show(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $institution = $entityManager->getRepository('App:Institution')->findOneBy(['type' => 'company']);
        //dump($institution);die;

        return $this->render('institution/show.html.twig', [
            'institution' => $institution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="institution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Institution $institution): Response
    {  $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
           /* $this->get('session')->getFlashBag()->add(
                    'sucess', array(
                'alert' => 'success',
                'title' => '',
                'message' => 'Informations de société modifiées'
            ));*/
            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute('institution_show');
        }

        return $this->render('institution/edit.html.twig', [
                    'institution' => $institution,
                    'form' => $form->createView(),
        ]);
    }
}
