<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait SizeTrait
{
    #[ORM\Column(nullable: true)]
    #[Groups(['read:stocks', 'read:article', 'read:orders', 'read:order', 'write:order'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Le prix doit être une chaîne de caractères.'
        ),
        new Assert\Regex(
            pattern: '/^(xxs|xs|s|m|l|xl|xxl|xxxl|XXS|XS|S|M|L|XL|XXL|XXXL|TU)$/',
            message: 'La format de la taille est invalide.'
        ),
    ])]
    private ?string $size = null;

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

        return $this;
    }
}
