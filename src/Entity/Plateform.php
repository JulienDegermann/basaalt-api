<?php

namespace App\Entity;

use App\Entity\Song;
use App\Entity\Album;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use App\Traits\DateEntityTrait;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PlateformRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlateformRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:plateform', 'read:plateforms', 'read:date']],
    denormalizationContext: ['groups' => ['write:plateform']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete()
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,

)]
class Plateform
{
    // createdAt and updatedAt properties, getters and setters
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:plateform', 'read:plateforms'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:plateform', 'read:plateforms', 'write:plateform'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Ce champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Ce champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z0-9\s\-]{2,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:plateform', 'read:plateforms', 'write:plateform'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Ce champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Ce champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^(https?|ftp):\/\/(www\.)?[^\s\/$?#]+\.[^\s]+$/',
            message: 'URL non valide.'
        )
    ])]
    private ?string $url = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
