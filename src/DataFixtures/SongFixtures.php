<?php

namespace App\DataFixtures;

use App\Entity\Song;
use App\Entity\Album;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SongFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $songs = [
            "song #1" => ['releasedAt' => new \DateTimeImmutable("01/01/2021 12:00:00")], 
            "song #2" => ['releasedAt' => new \DateTimeImmutable("01/02/2021 12:00:00")],
            "song #3" => ['releasedAt' => new \DateTimeImmutable("01/03/2021 12:00:00")],
            "song #4" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
            "song #5" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
            "song #6" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
            "song #7" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
            "song #8" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
            "song #9" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
            "song #10" => ['releasedAt' => new \DateTimeImmutable("01/04/2021 12:00:00")],
        ];

        foreach($songs as $key => $song){
            $current = new Song();
            $current->setTitle($key);
            $current->setReleasedAt($song['releasedAt']);
            $current->setAlbum($this->getReference("Album #" . rand(1, 4), Album::class));
            $manager->persist($current);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AlbumFixtures::class,
            PlateformFixtures::class
        ];
    }
}
