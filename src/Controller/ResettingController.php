<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


/**
     * @Route("/reset")
     */
class ResettingController extends AbstractController {


    /*public function reset(Request $request) {

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
    }*/

    /**
     * @Route("/", name="app_forgotten_password")
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator): Response
    {

        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'البريد الالكتروني الذي قمت بادخاله غير صحيح!');
                return $this->redirectToRoute('app_login');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            $url = $this->generateUrl('app_reset_password',
                array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Forgot Password'))
                ->setFrom('test.dipsociete@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "اضغط على هذا الرابط لإعادة تعيين كلمة المرور الخاصة بك : " . $url,
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('notice', 'تم ارسال البريد بنجاح!');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset/forgotten_password.html.twig');
    }
    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)
                                  ->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('app_login');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('notice', 'تم تحديث كلمة المرور');

            return $this->redirectToRoute('app_login');
        }else {

            return $this->render('reset/reset_password.html.twig', ['token' => $token]);
        }

    }

}
