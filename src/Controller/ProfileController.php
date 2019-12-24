<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile")
     */
    public function index()
    {
        // usually you'll want to make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class

        /** @var \App\Entity\User $user */

        $user = $this->getUser();

        // Call whatever methods you've added to your User class
        // For example, if you added a getEmail() method, you can use that.

        //return new Response('Well hi there '.$user->getEmail());

        $em= $this->getDoctrine()->getManager();
        $users= $em->getRepository(User::class)->findOneByEmail($user->getEmail());
        //$users=$user->getEmail();
        //dump($users);die;
        return $this->render('profile/index.html.twig', [
            'user' => $users,
        ]);
    }
    /** modifier profile
     * @Route("/edit/{id}", name="profile_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dump($users),die;
        $form = $this->createForm(UserType::class, $user);
        $formView = $form->createView();
        $form->handleRequest($request);
        //dump($user);die;
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "تم تغيير معطيات المستخدم بنجاح");
            return $this->redirect($this->generateUrl('profile'));
        }
        return $this->render('profile/edit.html.twig', [
            'form' => $formView,
            'user' => $user,
        ]);
    }

}
