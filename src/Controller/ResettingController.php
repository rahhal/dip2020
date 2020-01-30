<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
     * @Route("/reset")
     */
class ResettingController extends AbstractController {

    /**
     * @Route("/", name="reset_index", methods={"GET"})
     *
     * @return Response
     */
    public function reset(Request $request) {

        $form_reset = $this->createFormBuilder(null)
            ->add('email', EmailType::class)
            ->getForm();

        $form_reset->handleRequest($request);

        if ($form_reset->isSubmitted() && $form_reset->isValid()) {
            // data is an array with "name", "email", and "message" keys
           // $data = $form_reset->getData();


            $data = $form_reset->getData();
            $check_email = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $data['email']]);

            if (!is_null($check_email)) {
                $this->sendEmail($check_email->getEmail());
            }

            var_dump($data);
        }

        return $this->render('reset/reset.html.twig', [
            'form_reset' => $form_reset->createView()
        ]);


//        return $this->render('reset/reset.html.twig');
    }
    private function sendEmail($email) {
        var_dump($email);
    }


}
