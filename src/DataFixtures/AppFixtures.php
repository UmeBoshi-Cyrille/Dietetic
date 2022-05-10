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
        // Regime
        $regimes = [];
        for ($r = 0; $r <= 10; $r++) {
            // $product = new Product();
            // $manager->persist($product);
            $regime = new Regime();
            $regime->setName($this->faker->word())
                ->setDescription($this->faker->text());
    
            $regimes[] = $regime;
            $manager->persist($regime);
        }

        // Allergene
        $allergenes = [];
        for ($a = 0; $a <= 10; $a++) {
            // $product = new Product();
            // $manager->persist($product);
            $allergene = new Allergene();
            $allergene->setName($this->faker->word())
                ->setDescription($this->faker->text());
    
            $allergenes[] = $allergene;
            $manager->persist($allergene);
        }

        // Ingredients
        $ingredients = [];
        for ($i = 0; $i <= 60; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setDescription($this->faker->text());
    
            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }

        // Recipes
        for ($j = 0; $j <= 10; $j++) {
            $recette = new Recette();
            $recette->setName($this->faker->word())
                ->setDescription($this->faker->text())
                ->setPreparationTime(mt_rand(5, 60), 'minutes')
                ->setStep($this->faker->text());
            
            for ($k = 0; $k < mt_rand(5, 15); $k++) {
                $recette->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }
            for ($s = 0; $s < mt_rand(1, 10); $s++) {
                $recette->addAllergene($allergenes[mt_rand(0, count($allergenes) - 1)]);
            }
            for ($t = 0; $t < mt_rand(1, 5); $t++) {
                $recette->addRegime($regimes[mt_rand(0, count($regimes) - 1)]);
            }

            $manager->persist($recette);
        }

        $manager->flush();
    }
}
