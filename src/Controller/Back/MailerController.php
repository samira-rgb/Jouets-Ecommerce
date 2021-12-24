<?php

namespace App\Controller\Back;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('Bjouetstest@gmail.com')
            ->to('Bjouetstest@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('bienvenu chez Bjouet!')
            ->text('Test success envoie email à l\'uilisateur!')
            ->html('<p>YOUPPPIIIII!</p>');

        $mailer->send($email);
    }
}
