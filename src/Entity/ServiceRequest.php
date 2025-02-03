<?php

namespace App\Entity;

use App\Repository\ServiceRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRequestRepository::class)]
class ServiceRequest
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int     $id = null,

        #[ORM\Column(length: 255)]
        private ?string  $email = null,

        #[ORM\ManyToOne(inversedBy: 'serviceRequests')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Service $service = null,

        #[ORM\ManyToOne(inversedBy: 'serviceRequests')]
        #[ORM\JoinColumn(nullable: false)]
        private ?User    $user = null,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
