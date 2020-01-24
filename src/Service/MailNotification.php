<?php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;
//use App\Repository\IPRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;


class MailNotification
{
    /**
    *@var \Swift_Mailer
    */
    protected $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    private $em;

    public function __construct(\Swift_Mailer $mailer,Environment $renderer,EntityManagerInterface $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->renderer = $renderer;
    }
    public function notifieParEmail($contact,$subject,$sender, $receiver, $body)
    {
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($sender)
            ->setTo($receiver)
            ->setBody($body, 'text/html','UTF-8');
        //dump($message);
        $this->mailer->send($message);
    }
    /*public function ArParEmail(UserInterface $user)
    {
        $from = 'test.dipsociete@gmail.com';
        $vue = "contact/registration.html.twig";
        $objet= "Enregistrement du nouveau membre ".$user->getUsername();
        $this->em->flush();
        $message = (new \Swift_Message())
            ->setSubject($objet)
            ->setFrom($from)
            ->setTo($from)
            ->setBody(
                $this->templating->render(
                    $vue,
                    array('objet'=>$objet,'user'=>$user)
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }*/
}