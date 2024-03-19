<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $categories = [
            "vêtements",
            "goodies",
            "instruments"
        ];

        foreach($categories as $category){
            $current = new Category();
            $current->setName($category);
            $manager->persist($current);
        }

        $manager->flush();
    }
}
