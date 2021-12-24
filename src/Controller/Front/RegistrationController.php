<?php

namespace App\Controller\Front;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Form\Front\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer, ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setEnabled(false);
            $user->setConfirmationToken(random_bytes(24));
            $user->setLastLoginAt(new \DateTimeImmutable());
            // dd($user);

            $lastname=$request->request->get('registration_form')['lastname'];
            $email=$request->request->get('registration_form')['email'];
            $firstname=$request->request->get('registration_form')['firstname'];
            

            

            $email = (new TemplatedEmail())
                ->from('fabien@example.com')
                ->to(new Address($email))
                ->subject('Thanks for signing up!')

                // path of the Twig template to render
                ->htmlTemplate('Back/email/signup.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => $lastname,
                    'firstname' => $firstname,
                ]);





            // $email = (new Email())
            //     ->from('Bjouetstest@gmail.com')
            //     ->to('test2@gmail.com')
            //     //->cc('cc@example.com')
            //     //->bcc('bcc@example.com')
            //     //->replyTo('fabien@example.com')
            //     //->priority(Email::PRIORITY_HIGH)
            //     ->subject('bienvenu chez Bjouet!')
            //     ->text('Test success envoie email à l\'uilisateur!')
            //     ->html('<p>Confirmation!</p>');

            // do anything else you need here, like send an email
            $mailer->send($email);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('Front/register.html.twig', [
            'formu' => $form->createView(),
        ]);
    }
}
