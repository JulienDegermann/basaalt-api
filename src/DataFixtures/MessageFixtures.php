<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Message;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {

    $messages = [];
    for ($i = 0; $i < 10; $i++) {
      $messages[] = "Message number $i";
    }

    foreach ($messages as $key => $message) {
      $current = new Message();
      $current->setAuthor($this->getReference('user' . rand(0, 2), User::class));
      $current->setText($message);
      $manager->persist($current);
    }
    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      UserFixtures::class,
    ];
  }
}
