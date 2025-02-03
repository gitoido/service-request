<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ServiceRequestController extends AbstractController
{
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    #[Route('/', name: 'app_service_request')]
    public function index(): Response
    {
        return $this->render('service_request/index.html.twig', [
            'controller_name' => 'ServiceRequestController',
        ]);
    }
}
