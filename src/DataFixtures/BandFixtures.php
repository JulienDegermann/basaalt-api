<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BandFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $members = [
      [
        "firsName" => "Thomas",
        "lastName" => "Basaalt",
        "bandRole" => "Drums"
      ],
      [
        "firsName" => "Jérémie",
        "lastName" => "Basaalt",
        "bandRole" => "Lead guitar"

      ],
      [
        "firsName" => "Alex",
        "lastName" => "Basaalt",
        "bandRole" => "Lead voice / Rythm guitar"
      ],
      [
        "firsName" => "Antoine",
        "lastName" => "Basaalt",
        "bandRole" => "Bass guitar / Back vocal"
      ]
    ];


    foreach ($members as $key => $user) {
      $currentUser = new User();
      $currentUser->setFirstName($user["firsName"]);
      $currentUser->setLastName($user["lastName"]);
      $currentUser->setEmail(strtolower($user["firsName"]) . "@basaalt.com");
      $currentUser->setRoles(["ROLE_ADMIN", "ROLE_USER"]);
      $currentUser->setBandRole($user["bandRole"]);
      $manager->persist($currentUser);
      $this->addReference("bandMember" . $key, $currentUser);
    }

    $manager->flush();

    $band = new Band();
    $band->setName("Basaalt");
    $band->setGenre("Groove métal alternatif");
    for ($i = 0; $i < 4; $i++) {
      $band->addBandMember($this->getReference("bandMember" . $i, User::class));
    }
    $manager->persist($band);
    $this->addReference('band', $band);

    $manager->flush();
  }
}
