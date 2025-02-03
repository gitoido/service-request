<?php
declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\Service;
use App\Entity\ServiceRequest;
use App\Form\ServiceRequestFormType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(
    'service_request_form'
)]
class ServiceRequestForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public bool $isSuccessful = false;

    #[LiveProp(writable: true)]
    public Service $selectedService;

    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        ServiceRepository $serviceRepository
    )
    {
        $this->selectedService = $serviceRepository->findOneBy([], ['id' => 'DESC']);
    }

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ServiceRequestFormType::class);
    }

    #[LiveAction]
    public function saveServiceRequest()
    {
        $this->submitForm();
        $this->isSuccessful = !$this->hasValidationErrors();

        if (!$this->isSuccessful) {
            return;
        }

        $request = $this->getForm()->getData();
        $request->setUser($this->security->getUser());

        $this->entityManager->persist($request);
        $this->entityManager->flush();
    }
}
