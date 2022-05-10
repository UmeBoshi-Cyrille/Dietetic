<?php

namespace App\DataFixtures;

use App\Entity\Allergene;
use App\Entity\Ingredient;
use App\Entity\Recette;
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

        for ($i = 0; $i <= 10; $i++) {
            // $product = new Product();
            // $manager->persist($product);
            $allergene = new Allergene();
            $allergene->setName($this->faker->word())
                ->setDescription('un Allergène');
    
            $manager->persist($allergene);
        }

        for ($i = 0; $i <= 10; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setDescription('un Ingrédient');
    
            $manager->persist($ingredient);
        }

        for ($i = 0; $i <= 10; $i++) {
            $recette = new Recette();
            $recette->setName($this->faker->word())
                ->setDescription('Une recette');
    
            $manager->persist($recette);
        }

        $manager->flush();
    }
}
