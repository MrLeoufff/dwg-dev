<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Envoi de l'email
            $email = (new Email())
                ->from($data['email'])
                ->to('developpeur.web.gard@gmail.com')
                ->subject('Nouveau message via le formulaire de contact')
                ->text(sprintf(
                    "Nom : %s\nEmail : %s\nMessage :\n\n%s",
                    $data['name'],
                    $data['email'],
                    $data['message']
                ));

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
