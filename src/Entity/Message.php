<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:messages', 'read:message']],
    denormalizationContext: ['groups' => ['write:message']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete()

    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:messages', 'read:message'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['read:messages', 'read:message'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:messages', 'read:message', 'write:message'])]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'messages', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:messages', 'read:message', 'write:message'])]
    private ?User $author = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getauthor(): ?User
    {
        return $this->author;
    }

    public function setauthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
