<?php

namespace App\Controller;

use App\Form\ServiceRequestFormType;
use App\Repository\ServiceRequestRepository;
use App\Twig\Components\ServiceRequestForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ServiceRequestController extends AbstractController
{
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    #[Route('/', name: 'app_service_request')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $form = $this->createForm(ServiceRequestFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRequest = $form->getData();
            $serviceRequest->setUser($this->getUser());
            $entityManager->persist($serviceRequest);
            $entityManager->flush();
            $this->addFlash('success', 'Service request added!');
        }

        return $this->render('service_request/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
