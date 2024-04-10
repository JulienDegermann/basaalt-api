<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Traits\QuantityTrait;
use ApiPlatform\Metadata\Post;
use App\Traits\DateEntityTrait;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    normalizationContext: ['groups' => ['read:orders', 'read:order', 'read:date']],
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
    use DateEntityTrait;
    use QuantityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:orders', 'read:order'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?UserOrder $userOrder = null;

    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'orders')]
    private Collection $stocks;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function __toString(): string
    // {
    //     return $this->id;
    // }

    public function getUserOrder(): ?UserOrder
    {
        return $this->userOrder;
    }

    public function setUserOrder(?UserOrder $userOrder): static
    {
        $this->userOrder = $userOrder;

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setOrders($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getOrders() === $this) {
                $stock->setOrders(null);
            }
        }

        return $this;
    }
}
