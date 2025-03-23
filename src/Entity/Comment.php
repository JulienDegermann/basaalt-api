<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Traits\DateEntityTrait;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommentRepository;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:comments', 'read:comment', 'read:date']],
    denormalizationContext: ['groups' => ['write:comment']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete()
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Comment
{
    // createdAt and updatedAt properties, getters and setters
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:comments', 'read:comment'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:comments', 'read:comment', 'write:comment'])]
    #[Assert\Sequentially([
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
            pattern: '/^[a-zA-Z0-9\s\-,?!.\p{L}]{5,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $text = null;

    // Assert makes toggle not effective on back-office'index only, works on back-office'edit
    #[ORM\ManyToOne(inversedBy: 'comments', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:comments', 'read:comment', 'write:comment'])]
    // #[Assert\Valid]
    private ?User $author = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['read:comments', 'read:comment', 'write:comment'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'boolean',
            message: 'Le format est invalide.'
        )
    ])]
    private bool $isValid = false;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
