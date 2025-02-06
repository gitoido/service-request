<?php

namespace App\Tests\Controller;

use App\Entity\ServiceRequest;
use App\Repository\ServiceRepository;
use App\Repository\ServiceRequestRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ServiceRequestControllerTest extends WebTestCase
{
    public function testShouldReturn401Unauthorized(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseStatusCodeSame(403);
    }

    public function testShouldReturn200Authorized(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('user@example.com');

        $client->loginUser($user);
        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }

    public function testShouldNotAllowInvalidEmail(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('user@example.com');

        $serviceRepository = static::getContainer()->get(ServiceRepository::class);
        $service = $serviceRepository->findOneBy(['id' => 1]);

        $client->loginUser($user);
        $client->request('GET', '/');

        $client->submitForm("Send new request", [
            'service_request_form[service]' => $service->getId(),
            'service_request_form[email]' => "test@test",
        ]);

        self::assertSelectorExists(
            "#service_request_form_email.is-invalid",
            "This value is not a valid email address."
        );
    }

    public function testShouldCreateNewService(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $serviceRepository = static::getContainer()->get(ServiceRepository::class);

        $user = $userRepository->findOneByEmail('user@example.com');
        $service = $serviceRepository->findOneBy(['id' => 1]);
        $email = "success@test.test";

        $client->loginUser($user);
        $client->request('GET', '/');
        $client->submitForm("Send new request", [
            'service_request_form[service]' => $service->getId(),
            'service_request_form[email]' => $email,
        ]);

        $serviceRequestRepository = static::getContainer()->get(ServiceRequestRepository::class);
        $serviceRequest = $serviceRequestRepository->findOneBy(['service' => $service->getId(), 'email' => $email, 'user' => $user->getId()]);

        self::assertInstanceOf(ServiceRequest::class, $serviceRequest);
        self::assertSame($email, $serviceRequest->getEmail());
        self::assertSame($service->getId(), $serviceRequest->getService()->getId());
        self::assertSame($user->getId(), $serviceRequest->getUser()->getId());

        self::assertSelectorExists(".alert-success");
    }
}
