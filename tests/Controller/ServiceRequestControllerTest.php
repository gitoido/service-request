<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ServiceRequestControllerTest extends WebTestCase
{
    public function testShouldReturn401Unauthorized(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseStatusCodeSame(401);
    }
}
