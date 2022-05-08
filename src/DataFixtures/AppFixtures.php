<?php

namespace App\DataFixtures;

use App\Entity\Regime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {
            // $product = new Product();
            // $manager->persist($product);
            $regime = new Regime();
            $regime->setName($this->faker->word())
                ->setDescription('un régime');
    
            $manager->persist($regime);
        }

        $manager->flush();
    }
}
