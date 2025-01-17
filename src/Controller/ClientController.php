<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/acceuil', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/acceuil.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
