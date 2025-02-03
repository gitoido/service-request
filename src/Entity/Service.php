<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int       $id = null,

        #[ORM\Column(length: 255)]
        private ?string    $name = null,

        #[ORM\Column]
        private ?int       $price = null,

        /**
         * @var Collection<int, ServiceRequest>
         */
        #[ORM\OneToMany(targetEntity: ServiceRequest::class, mappedBy: 'service')]
        private Collection $serviceRequests = new ArrayCollection(),
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, ServiceRequest>
     */
    public function getServiceRequests(): Collection
    {
        return $this->serviceRequests;
    }

    public function addServiceRequest(ServiceRequest $serviceRequest): static
    {
        if (!$this->serviceRequests->contains($serviceRequest)) {
            $this->serviceRequests->add($serviceRequest);
            $serviceRequest->setService($this);
        }

        return $this;
    }

    public function removeServiceRequest(ServiceRequest $serviceRequest): static
    {
        if ($this->serviceRequests->removeElement($serviceRequest)) {
            // set the owning side to null (unless already changed)
            if ($serviceRequest->getService() === $this) {
                $serviceRequest->setService(null);
            }
        }

        return $this;
    }
}
