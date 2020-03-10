<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/superUser")
 * @IsGranted("ROLE_SUPER_ADMIN", message="No access! Get out!")
 */
class SuperUserController extends AbstractController
{
    /**
     * Lists all User entities.
     * @Route("/", name="super_user_list")
     */

    public function index()
    {
        $em= $this->getDoctrine()->getManager();
        $users= $em->getRepository(User::class)->findByRole('ROLE_USER');
        // dump($users);die;
        return $this->render('super_user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**  l'ajout de user
     * @Route("/new", name="super_user_new")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em= $this->getDoctrine()->getManager();
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //  Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "تمت اضافة  المستخدم بنجاح");

            return $this->redirect($this->generateUrl('super_user_list'));
        }
        return $this->render('super_user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /** modifier user
     * @Route("/edit/{id}", name="super_user_edit")
     */
    public function editAction(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em= $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dump($users),die;
        $form = $this->createForm(UserType::class, $user);
        $formView = $form->createView();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "تم تغيير معطيات المستخدم بنجاح");

            return $this->redirect($this->generateUrl('super_user_list'));
        }

        return $this->render('super_user/edit.html.twig', [
            'form' => $formView,
            'user' => $user,
        ]);

    }
    /** show user
     * @Route("/show/{id}", name="super_user_show")
     */
    public function showAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dump($users);
        //die;
        return $this->render('super_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /** delete user
     * @Route("/delete/{id}", name="super_user_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dump($user),die;
        if($user) {
            $em->remove($user);
            $em->flush();

            $this->addFlash('success', "تم حذف المستخدم بنجاح");

            return $this->redirect($this->generateUrl('super_user_list'));
        }
    }


}