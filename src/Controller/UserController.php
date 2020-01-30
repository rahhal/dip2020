<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserAdminType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/user")
 * @IsGranted("ROLE_SUPER_ADMIN", message="No access! Get out!")
 */
class UserController extends AbstractController
{
    /**
     * Lists all User entities.
     * @Route("/", name="user_list")
     */

    public function index()
    {
        $em= $this->getDoctrine()->getManager();
        $users= $em->getRepository(User::class)->findByRole('ROLE_ENTREPRISE');
        // dump($users);die;
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**  l'ajout de user
     * @Route("/new", name="user_new")
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

            //$user->addRole("ROLE_ADMIN");
            //  save the User!
            $user->setRoles(['ROLE_ENTREPRISE']);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "تمت اضافة  المستخدم بنجاح");

            return $this->redirect($this->generateUrl('user_list'));
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /** modifier user
     * @Route("/edit/{id}", name="user_edit")
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

            return $this->redirect($this->generateUrl('user_list'));
        }

        return $this->render('user/edit.html.twig', [
            'form' => $formView,
            'user' => $user,
        ]);

    }
    /** show user
     * @Route("/show/{id}", name="user_show")
     */
    public function showAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dump($users);
        //die;
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /** delete user
     * @Route("/delete/{id}", name="user_delete")
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

            return $this->redirect($this->generateUrl('user_list'));
        }
    }


}