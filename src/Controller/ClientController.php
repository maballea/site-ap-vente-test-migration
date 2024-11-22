<?php

// src/Controller/ClientController.php
namespace App\Controller;

use App\Entity\Client;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class ClientController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(Security $security): Response
    {
        $client = $security->getUser();
        return $this->render('client/home.html.twig', [
            'client' => $client
        ]);
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $client = new Client();
        $form = $this->createForm(RegistrationFormType::class, $client);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setMotDePasse($passwordEncoder->encodePassword($client, $client->getMotDePasse()));
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion après l'inscription
        }

        return $this->render('client/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/connexion', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('client/login.html.twig');
    }

    #[Route('/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony gère la déconnexion automatiquement
    }
}
