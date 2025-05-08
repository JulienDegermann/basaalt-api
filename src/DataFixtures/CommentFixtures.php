<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {

  //   $comments = [];
  //   for ($i = 0; $i < 10; $i++) {
  //     $comments[] = "Comment number $i";
  //   }

  //   foreach ($comments as $key => $comment) {
  //     $current = new Comment();
  //     $current->setAuthor($this->getReference('commentUser' . rand(0, 2), User::class));
  //     $current->setText($comment);
  //     $manager->persist($current);
  //   }
  //   $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      UserFixtures::class,
    ];
  }
}
