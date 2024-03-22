<?php

namespace App\DataFixtures;

use App\Entity\Plateform;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PlateformFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $plateforms = [
            "Youtube" => "https://www.youtube.com/@basaalt",
            "Deezer" => "https://www.deezer.com/",
            "Spotify" => "https://open.spotify.com/artist/5CP1jB3dlYFMZgA9iC8fUd",
            "Apple Music" => "https://www.apple.com/fr/music/",
            "Soundcloud" => "https://soundcloud.com/",
            "Facebook" => "https://www.facebook.com/basaaltband/",
            "Instagram" => "https://www.instagram.com/basaalt_officiel",
        ];

        foreach ($plateforms as $key => $plateform) {
            $current = new Plateform();
            $current->setName($key);
            $current->setUrl($plateform);
            $manager->persist($current);
        }

        $manager->flush();
    }
}
