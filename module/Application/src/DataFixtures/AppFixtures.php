<?php

namespace Application\DataFixtures;

use Client\Entity\Address;
use Client\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var Factory
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; ++$i) {
            $client = new Client();
            $client->setName($this->faker->name);
            $client->setEmail($this->faker->email);
            $client->setPhone($this->faker->e164PhoneNumber);

            $manager->persist($client);
            // Create Address
            for ($j = 0; $j < rand(1, 10); ++$j) {
                $address = new Address();
                $address->setCity($this->faker->city);
                $address->setAddress($this->faker->address);

                $address->setClient($client);

//                $manager->persist($address);
            }
        }

        $manager->flush();
    }
}
