<?php

namespace App\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

trait ColorTrait
{
    #[ORM\Column(nullable: true)]
    #[Groups(['read:stock', 'read:article', 'write:order'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Le code couleur doit être une chaîne de caractères.'
        ),
        new Assert\Regex(
            pattern: '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            message: 'La code couleur hexadécimal est invalide.'
        )
    ])]
    private ?string $color = null;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }
}
