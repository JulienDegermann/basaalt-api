<?php

namespace App\Traits;

use App\Entity\ArticleCommand;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait QuantityTrait
{
    #[ORM\Column]
    #[Groups(['read:quantity', 'write:order', 'read:stock', 'read:stocks'])]
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
        ),
    ])]
    private ?int $quantity = null;

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        if ($this instanceof ArticleCommand) {
            if ($this->stock && $quantity > $this->stock->getQuantity()) {
                throw new InvalidArgumentException("La quantité en stock est insuffisante.");
            }
        }

        $this->quantity = $quantity;

        return $this;
    }
}
