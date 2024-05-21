<?php

namespace App\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

trait SizeTrait
{
  #[ORM\Column]
  #[Groups(['read:stock', 'read:article', 'write:order'])]
  #[Assert\Sequentially([
      new Assert\NotBlank(
          message: 'Ce champ est obligatoire.'
      ),
      new Assert\Type(
          type: 'string',
          message: 'Le prix doit être une chaîne de caractères.'
      ),
      new Assert\Regex(
          pattern: '/^(xxs|xs|s|m|l|xl|xxl|xxxl|XXS|XS|S|M|L|XL|XXL|XXXL|TU)$/',
          message: 'La format de la taille est invalide.'
      )
  ])]
  private ?string $size = null;

  public function getSize(): ?string
  {
      return $this->size;
  }

  public function setSize(string $size): static
  {
      $this->size = $size;

      return $this;
  }
}
