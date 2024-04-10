<?php

namespace App\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

trait QuantityTrait
{

  #[ORM\Column]
  #[Groups(['read:stock', 'write:order'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'integer',
            message: 'La quantité doit être un nombre entier.'
        ),
        new Assert\PositiveOrZero(
            message: 'La quantité doit être supérieure ou égale à 0.'
        ),
        new Assert\LessThanOrEqual(
            9999,
            message: 'La quantité doit être inférieure ou égale à {{ value }}.'
        ),
        new Assert\GreaterThanOrEqual(
            0,
            message: 'La quantité doit être supérieure ou égale à {{ value }}.'
        )
    ])]
    private ?int $quantity = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
