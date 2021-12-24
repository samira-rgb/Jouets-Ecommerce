<?php

namespace App\Controller;



use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, LoginFormAuthenticator $login): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $this->addFlash('success', 'Bienvenue chez Bjouets ');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        $this->addFlash('success', 'Vous etes déconnecté ');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    // /**
    //  * @Route("/forget_password", name="app_forget_password")
    //  */
    // public function forgetPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    // {
    //     $form = $this->createForm(ForgetPasswordFormType::class);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $user = $userRepository->findOneByEmail($form->get('email')->getData());
    //         if ($user) {
    //             $user->setConfirmationToken(random_bytes(24));
    //             $this->getDoctrine()->getManager()->flush();
    //             $mailer->sendForgetPassword($user);
    //             $msg = $this->translator->trans('forget_password.flash.check_email', ['%user%' => $user,], 'security');
    //             $this->addFlash('success', $msg);
    //         }
    //         return $this->redirectToRoute('front_home');
    //     }
    //     return $this->render('security/forget_password.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
}
