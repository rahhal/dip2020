<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailNotification;
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
    public function ajout(Request $request, MailNotification $notificationMail)
    {
        $contact= new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $subject= $contact->getObject();
            /*$sender='test.dipsociete@gmail.com';
            $receiver=$contact->getEmail();*/
            $receiver ='test.dipsociete@gmail.com';
            $sender=$contact->getEmail();
            $body=$contact->getMessage();

            $notificationMail->notifieParEmail( $contact,$subject,$sender, $receiver, $body);
            $em->persist($contact);

            $em->flush();

            $this->addFlash('success', "تم ارسال الرسالة بنجاح");
           return $this->redirect($this->generateUrl('contact_ajout'));
        }
            return $this->render('contact/registration.html.twig', [
                'contact'=> $contact,
                'form' => $form->createView(),


        ]);
    }

}
