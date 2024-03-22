<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\DataFixtures\PlateformFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $albums = [
            "Album #1" => ['releasedAt' => new \DateTimeImmutable("01/01/2021 12:00:00")], 
            "Album #2" => ['releasedAt' => new \DateTimeImmutable("01/02/2021 12:00:00")],
            "Album #3" => ['releasedAt' => new \DateTimeImmutable("01/03/2021 12:00:00")],
            "Album #4" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
        ];

        foreach($albums as $key => $album){
            $current = new Album();
            $current->setTitle($key);
            $current->setReleasedAt($album['releasedAt']);
            $current->setBand($this->getReference('band'));
            $manager->persist($current);
            $this->addReference($key, $current);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            PlateformFixtures::class,
            BandFixtures::class
        ];
    }
}
