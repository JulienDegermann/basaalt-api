<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

  public function __construct(
    private readonly UserPasswordHasherInterface $hasher

  ) {}

  public function load(ObjectManager $manager): void
  {

    // $users = [
    //   'comments' => [
    //     [
    //       'userName' => "John",
    //       'email' => "john@example.com"
    //     ],
    //     [
    //       'userName' => "Mary",
    //       'email' => "mary@example.com"
    //     ],
    //     [
    //       'userName' => "Ash",
    //       'email' => "ahs@example.com"
    //     ]
    //   ],
    //   'any' => [
    //     [
    //       'firstName' => 'Jack',
    //       'lastName' => 'Doe',
    //     ],
    //     [
    //       'firstName' => 'Julien',
    //       'lastName' => 'Degermann',
    //     ],
    //     [
    //       'firstName' => 'Jean',
    //       'lastName' => 'Marie',
    //     ],
    //   ]
    // ];


    // foreach ($users as $key => $userArray) {
    //   foreach ($userArray as $userKey => $user) {

    //     $current = new User();
    //     if ($key === 'comments') {
    //       $current->setUserName($user['userName']);
    //       $current->setEmail($user['email']);
    //     } else {
    //       $current->setFirstName($user['firstName']);
    //       $current->setLastName($user['lastName']);
    //       $current->setEmail($user['firstName'] . '@example.com');
    //     }
    //     if ($key === 'comments') {
    //       $this->addReference('commentUser' . $userKey, $current);
    //     } else {
    //       $this->addReference('user' . $userKey, $current);
    //     }
    //     $manager->persist($current);
    //   }
    // }

    $superAdmin = new User();

    $password = $this->hasher->hashPassword($superAdmin, 'monMotDePasse123!');
    $superAdmin
      ->setUserName('SuperAdmin')
      ->setEmail(getenv('SUPER_ADMIN_EMAIL'))
      ->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_USER'])
      ->setPassword($password)
      ->setFirstName('Super')
      ->setLastName('Admin')
      ->setBirthDate(new \DateTimeImmutable('1988-10-18'));
    $manager->persist($superAdmin);

    $manager->flush();
  }
}
