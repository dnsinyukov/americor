<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\en_US\Person;
use Random\RandomException;

class AppFixtures extends Fixture
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @param ObjectManager $manager
     * @return void
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        foreach (range(5, 10) as $client) {
            $client = (new Client())
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setPhone($this->faker->phoneNumber())
                ->setAddress($this->faker->address())
                ->setAge(\random_int(18, 60))
                ->setFico(\random_int(300, 850))
                ->setSsn(Person::ssn());

            $manager->persist($client);
        }

        $manager->flush();
    }
}
