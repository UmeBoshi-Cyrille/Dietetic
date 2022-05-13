<?php

namespace App\DataFixtures;

use App\Entity\Allergene;
use App\Entity\Ingredient;
use App\Entity\Recette;
use App\Entity\Regime;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        for ($j = 0; $j <= 100; $j++) {
            $recette = new Recette();
            $recette->setName($this->faker->word())
                ->setDescription($this->faker->text(300))
                ->setPreparationTime(mt_rand(5, 60), 'minutes')
                ->setStep($this->faker->text(1200))
                ->setIsPublished(mt_rand(0, 1) == 1 ? true : false);
            
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

        // User
        for ($i =0 ; $i < 10; $i++) {
            $user = new User();
            $user->setLastname($this->faker->lastName())
                ->setFirstname($this->faker->firstName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
            // $hashPassword = $this->hasher->hashPassword(
            //     $user,
            //     'password'
            // );

            // $user->setPassword($hashPassword);

            for ($a = 0; $a < mt_rand(1, 3); $a++) {
                $user->addAllergene($allergenes[mt_rand(0, count($allergenes) - 1)]);
            }
            for ($r = 0; $r < mt_rand(1, 3); $r++) {
                $user->addRegime($regimes[mt_rand(0, count($regimes) - 1)]);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
