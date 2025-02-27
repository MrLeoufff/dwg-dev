<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le mot de passe du formulaire
            $plainPassword = $form->get('plainPassword')->getData();
            // Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $user->setRoles(['ROLE_USER']);
            $user->setVerified(false);

            // Générer le token de vérification
            $verificationToken = $user->generateVerificationToken();
            $user->setResetToken($verificationToken);

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoyer l'email de vérification
            $url = $this->generateUrl('app_verify_email', ['token' => $verificationToken], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);

            $emailMessage = (new \Symfony\Component\Mime\Email())
                ->from('developpeur.web.gard@gmail.com')
                ->to($user->getEmail())
                ->subject('Vérification de votre compte')
                ->html('<p>Cliquez sur ce lien pour vérifier votre compte :
                        <a href="' . $url . '">Vérifiez votre compte</a></p>');

            try {
                $mailer->send($emailMessage);
            } catch (\Throwable $th) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email.');
            }

            $this->addFlash('success', 'Inscription réussie ! Veuillez vérifier votre email.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify-email/{token}', name: 'app_verify_email')]
    public function verifyEmail(string $token, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_register');
        }

        $user->setVerified(true);
        $user->setResetToken(null);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte a été vérifié avec succès !');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                $user->setResetToken($user->generateVerificationToken());
                $entityManager->flush();

                $url = $this->generateUrl('app_reset_password', ['token' => $user->getResetToken()], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);

                $emailMessage = (new \Symfony\Component\Mime\Email())
                    ->from('developpeur.web.gard@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de mot de passe')
                    ->html('<p>Cliquez sur ce lien pour réinitialiser votre mot de passe :
                    <a href="' . $url . '">Réinitialisez votre mot de passe</a></p>');
                try {
                    $mailer->send($emailMessage);
                } catch (\Throwable $th) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email.');
                }
            }

            $this->addFlash('success', 'Si un compte existe pour cet email, un lien a été envoyé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/forgot_password.html.twig');
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function resetPassword(string $token, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_forgot_password');
        }

        if ($request->isMethod('POST')) {
            $newPassword = $request->request->get('new_password');
            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            $user->setResetToken(null);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/reset_password.html.twig', ['token' => $token]);
    }
}
