<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     */
    public function index()
    {


        /*$em= $this->getDoctrine()->getManager();
        $contacts= $em->getRepository(Contact::class)->findOneByEmail($contact->getEmail());
        //$users=$user->getEmail();
        //dump($users);die;
        return $this->render('profile/index.html.twig', [
            'contact' => $contacts,
        ]);*/
    }
    /** ajout contact
     * @Route("/ajout", name="contact_ajout")
     */
    public function ajout(Request $request)
    {
        $contact= new Contact();

        $em= $this->getDoctrine()->getManager();
       // $contact = $em->getRepository(Contact::class)->find($id);
        // dump($users),die;
        $form = $this->createForm(ContactType::class, $contact);
        $formView = $form->createView();
        $form->handleRequest($request);
        //dump($user);die;
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "تم ارسال الرسالة بنجاح");
            //return $this->redirect($this->generateUrl('profile'));
        }
        return $this->render('contact/registration.html.twig', [
            'form' => $formView,
            'contact' => $contact,
        ]);
    }

}
