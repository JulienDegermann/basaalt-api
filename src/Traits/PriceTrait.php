<?php

namespace App\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

trait PriceTrait
{
    #[ORM\Column]
    #[Groups(['read:stock', 'write:order'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'float',
            message: 'Le prix doit être un nombre.'
        ),
        new Assert\PositiveOrZero(
            message: 'Le prix doit être supérieur ou égal à 0.'
        ),
        new Assert\LessThanOrEqual(
            9999,
            message: 'Le prix doit être inférieur ou égal à {{ value }}.'
        ),
        new Assert\GreaterThanOrEqual(
            0,
            message: 'Le prix doit être supérieur ou égal à {{ value }}.'
        )
    ])]
    private ?float $price = null;

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
