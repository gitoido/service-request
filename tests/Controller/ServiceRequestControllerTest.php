<?php

namespace App\Tests\Controller;

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
}
