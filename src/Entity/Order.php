<?php

namespace App\Entity;

use App\Entity\Stock;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    normalizationContext: ['groups' => ['read:orders', 'read:order']],
    denormalizationContext: ['groups' => ['write:order']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete(),
        new Put()

    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:orders', 'read:order'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:orders', 'read:order'])]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups(['read:orders', 'read:order'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read:orders', 'read:order'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['read:orders', 'read:order'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $buyer = null;

    #[ORM\ManyToMany(targetEntity: Stock::class, inversedBy: 'orders')]
    #[Groups(['read:orders', 'read:order'])]
    private Collection $stock;

    public function __construct()
    {
        $this->stock = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
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

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stock->contains($stock)) {
            $this->stock->add($stock);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        $this->stock->removeElement($stock);

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
