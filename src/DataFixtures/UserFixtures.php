<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class UserFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {

    $users = [
      'comments' => [
        [
          'userName' => "John",
          'email' => "john@example.com"
        ],
        [
          'userName' => "Mary",
          'email' => "mary@example.com"
        ],
        [
          'userName' => "Ash",
          'email' => "ahs@example.com"
        ]
      ],
      'any' => [
        [
          'firstName' => 'Jack',
          'lastName' => 'Doe',
        ],
        [
          'firstName' => 'Julien',
          'lastName' => 'Degermann',
        ],
        [
          'firstName' => 'Jean',
          'lastName' => 'Marie',
        ],
      ]
    ];


    foreach ($users as $key => $userArray) {
      foreach ($userArray as $userKey => $user) {

        $current = new User();
        if ($key === 'comments') {
          $current->setUserName($user['userName']);
          $current->setEmail($user['email']);
        } else {
          $current->setFirstName($user['firstName']);
          $current->setLastName($user['lastName']);
          $current->setEmail($user['firstName'] . '@example.com');
        }
        if ($key === 'comments') {
         $this->addReference('commentUser' . $userKey, $current);
        } else {
          $this->addReference('user' . $userKey, $current);
        }
        $manager->persist($current);
      }
    }

    $manager->flush();
  }
}
