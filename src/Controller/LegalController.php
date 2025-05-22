<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function index(): Response
    {
        return $this->render('legal/index.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'app_politique_confidentialite')]
    public function privacy(): Response
    {
        return $this->render('legal/privacy.html.twig');
    }
}
