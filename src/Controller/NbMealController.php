<?php

namespace App\Controller;

use App\Entity\NbMeal;
use App\Form\NbMealType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/nb/meal")
 * @Security("is_granted('ROLE_ENTREPRISE') or is_granted('ROLE_USER')", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */

class NbMealController extends AbstractController
{


    /** insert into l'ajout
     * @Route("/new", name="nb_meal_new")
     */
    public function newAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $nbMeal = new NbMeal();

        //on recupere le formulaire

        $form = $this->createForm(NbMealType::class, $nbMeal);
        //on genere le html de formulaire crée
        $formView = $form->createView();
        //pour conserver les données saisis par l'utilisateur en cas d'erreur
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           /* $data=$form->getData();
            $date=$data->getDate();*/
              // dump($nbMeal);die();
            $em->persist($nbMeal);
            $em->flush();

            $this->addFlash('success', "تمت الاضافة بنجاح");
            return $this->redirect($this->generateUrl('nb_meal_new'));
        }

        $nbMeals= $em->getRepository(NbMeal::class)->findAll();

        return $this->render('nb_meal/nbMeal.html.twig', [
            'form' => $formView,
            'nbMeals'=> $nbMeals,
        ]);
    }
    /** edit Nb meal
     * @Route("/edit/{id}", name="nb_meal_edit")
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function editAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $nbMeal = $em->getRepository(NbMeal::class)->find($id);
        // dump($categories);
        //die;
        $form = $this->createForm(NbMealType::class, $nbMeal);
        //on genere le html de formulaire crée
        $formView = $form->createView();
        //pour conserver les données saisis par l'utilisateur en cas d'erreur
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "تم التغيير بنجاح");
            // la redirection vers la page d'acceuil aprés l'ajout
            return $this->redirect($this->generateUrl('nb_meal_new'));
        }

        return $this->render('nb_meal/edit.html.twig', [
            'form' => $formView,
            'nbMeal' => $nbMeal,
        ]);
    }
    /** show nb Meal
     * @Route("/show/{id}", name="nb_meal_show")
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function showAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $nbMeal = $em->getRepository(NbMeal::class)->find($id);
        // dump($nbMeal);
        //die;

        return $this->render('nb_meal/show.html.twig', [

            'nbMeal' => $nbMeal,
        ]);
    }
    /** delete nb meal
     * @Route("/delete/{id}", name="nb_meal_delete")
     * @IsGranted("ROLE_ENTREPRISE", message="! ليس لديك الحق في الدخول الى هذه الصفحةّ!")
     */
    public function deleteAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $nbMeal = $em->getRepository(NbMeal::class)->find($id);
        if($nbMeal) {
            $em->remove($nbMeal);
            $em->flush();

            $this->addFlash('success', "تم الحذف بنجاح");
            return $this->redirect($this->generateUrl('nb_meal_new'));

        }

    }
}
