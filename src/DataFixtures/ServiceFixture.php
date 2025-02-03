<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = [
            ["name" => "Request car evaluation", "price" => 50000],
            ["name" => "Request house evaluation", "price" => 100000],
            ["name" => "Request company evaluation", "price" => 200000],
        ];

        foreach ($services as $datum) {
            $service = new Service();
            $service->setName($datum['name']);
            $service->setPrice($datum['price']);
            $manager->persist($service);
        }

        $manager->flush();
    }
}
