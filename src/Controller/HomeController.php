<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, ProductRepository $productRepository, MailerInterface $mailer): Response
    {
        $formations = $productRepository->findBy(['type' => 'formation']);

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            // Création du message email
            $emailMessage = (new Email())
                ->from('reneleliard@gmail.com')
                ->to('developpeur.web.gard@gmail.com')
                ->subject('Nouveau message via le formulaire de contact')
                ->text("Nom: $name\nEmail: $email\nMessage:\n$message");

            try {
                $mailer->send($emailMessage);
                $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de l\'envoi de votre message : ' . $e->getMessage());
            }
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'formations' => $formations,
        ]);
    }
}
