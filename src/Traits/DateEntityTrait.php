<?php

namespace App\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait DateEntityTrait
{
    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    // define create and update dates => use group 'read:date' for get dates via API Platform
    #[ORM\Column]
    #[Groups(['read:orders', 'read:orders'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'datetimeimmutable',
            message: 'Ce champ doit être une date valide.'
        ),
        new Assert\LessThanOrEqual(
            value: 'now',
            message: 'La date ne peut pas être postérieure à la date du jour.'
        ),
    ])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read:orders', 'read:orders'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'datetimeimmutable',
            message: 'Ce champ doit être une date valide.'
        ),
        new Assert\LessThanOrEqual(
            value: 'now',
            message: 'La date ne peut pas être postérieure à la date du jour.'
        ),
    ])]
    private ?DateTimeImmutable $updatedAt = null;

    // define getters and setters for create and update dates
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
