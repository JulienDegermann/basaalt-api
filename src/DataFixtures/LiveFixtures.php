<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Live;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LiveFixtures extends Fixture
{
    public function load(
      ObjectManager $manager): void
    {
      $cityRepo = $manager->getRepository(City::class);     

      $cities = $cityRepo->findAll();


        $lives = [
          [
            "enventDate" => new \DateTimeImmutable("2021-12-01"),
            "eventName" => "Basaalt en concert",
            "address" => "1 rue de la paix",
          ],            
          [
            "enventDate" => new \DateTimeImmutable("2021-12-01"),
            "eventName" => "Basaalt en concert",
            "address" => "1 rue de la paix",
          ],            
          [
            "enventDate" => new \DateTimeImmutable("2021-12-01"),
            "eventName" => "Basaalt en concert",
            "address" => "1 rue de la paix",
          ],            
          [
            "enventDate" => new \DateTimeImmutable("2021-12-01"),
            "eventName" => "Basaalt en concert",
            "address" => "1 rue de la paix",
          ]    
        ];

        foreach($lives as $key => $live){
            $current = new Live();
            $current->setEventDate($live["enventDate"]);
            $current->setCity($cities[array_rand($cities)]); // random city
            $current->setEventName($live["eventName"]);
            $current->setAddress($live["address"]);

            $manager->persist($current);
        }

        $manager->flush();
    }
}
