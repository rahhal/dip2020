<?php

namespace App\Controller;

use App\Entity\NbMeal;
use App\Form\NbMealType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/nb/meal")
 */

class NbMealController extends AbstractController
{
    /**
     * number of meal.
     * @Route("/", name="nb_meal_index")
     */
    public function indexAction()
    {
        $em= $this->getDoctrine()->getManager();
        $nbMeals= $em->getRepository(NbMeal::class)->findAll();
        // dump($nbMeals);die;


        return $this->render('nb_meal/index.html.twig', [
            'nbMeals' => $nbMeals,
        ]);
    }

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
            return $this->redirect($this->generateUrl('nb_meal_index'));
        }
        return $this->render('nb_meal/new.html.twig', [
            'form' => $formView,
        ]);
    }
    /** edit Nb meal
     * @Route("/edit/{id}", name="nb_meal_edit")
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
            // la redirection vers la page d'acceuil aprés l'ajout
            return $this->redirect($this->generateUrl('nb_meal_index'));
        }

        return $this->render('nb_meal/edit.html.twig', [
            'form' => $formView,
            'nbMeal' => $nbMeal,
        ]);

    }
    /** show nb Meal
     * @Route("/show/{id}", name="nb_meal_show")
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
     */
    public function deleteAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $nbMeal = $em->getRepository(NbMeal::class)->find($id);
        // dump($categories);
        //die;

        if($nbMeal) {
            $em->remove($nbMeal);
            $em->flush();

            return $this->redirect($this->generateUrl('nb_meal_index'));

        }

    }
}
