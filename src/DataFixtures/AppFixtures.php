<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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
        for($i=1; $i <= mt_rand(10,25); $i++)
        {
            $product = new Product;
            $product->setTitle($this->faker->sentence(3))
                    ->setImage($this->faker->imageUrl(640, 480, 'product'))
                    ->setPrice($this->faker->randomFloat(2, 15, 250));

            $manager->persist($product);
        }
        $manager->flush();
    }
}
