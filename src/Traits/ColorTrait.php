<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait ColorTrait
{
    #[ORM\Column(nullable: true)]
    #[Groups(['read:stock', 'read:article', 'read:stocks'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Le code couleur doit être une chaîne de caractères.'
        ),
        new Assert\Regex(
            pattern: '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            message: 'La code couleur hexadécimal est invalide.'
        ),
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
