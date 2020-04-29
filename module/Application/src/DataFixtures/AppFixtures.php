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

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; ++$i) {
            $client = new Client($this->faker->name, $this->faker->email, $this->faker->e164PhoneNumber);

            $manager->persist($client);
            // Create Address
            for ($j = 0; $j < rand(1, 5); ++$j) {
                $address = new Address();
                $address->setCity($this->faker->city);
                $address->setAddress($this->faker->address);

                $client->addAddress($address);
            }
        }

        $manager->flush();
    }
}
