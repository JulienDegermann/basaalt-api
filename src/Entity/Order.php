<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OrderRepository;
use App\Traits\AddressTrait;
use App\Traits\DateEntityTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete(),
        new Put(),
    ],
    normalizationContext: ['groups' => ['read:orders', 'read:order']],
    denormalizationContext: ['groups' => ['write:order', 'write:quantity']],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Order
{
    use DateEntityTrait;
    use AddressTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:orders', 'read:order'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[Groups(['read:orders', 'read:order', 'write:orders', 'write:order'])]
    private ?User $buyer = null;

    #[ORM\OneToMany(targetEntity: ArticleCommand::class, mappedBy: 'order', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['read:orders', 'read:order', 'write:order'])]
    private Collection $articleCommands;

    #[ORM\Column(type: 'string')]
    #[Groups(['read:orders', 'read:order', 'read:date', 'write:order'])]
    private ?string $status;

    #[Groups(['read:orders', 'read:order', 'read:date'])]
    private ?float $totalPrice = 0;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:orders', 'read:order', 'read:date'])]
    private ?DateTimeImmutable $expectedDeliveryDate;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['read:orders', 'read:order', 'read:date'])]
    private ?string $deliveryUrl;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->articleCommands = new ArrayCollection();
    }

    public function getTotalPrice(): ?float
    {
        $price = 0;
        foreach ($this->articleCommands as $articleCommand) {
            $price += $articleCommand->getStock()->getArticle()->getPrice() * $articleCommand->getQuantity();
        }

        return $price;
    }

    public function setStatus(string $status): static
    {
        $allowedStatuses = [
            'saved',
            'paymentValid',
            'paymentNotValid',
            'send',
            'recieved',
            'back',
        ];
        if (!in_array($status, $allowedStatuses)) {
            throw new InvalidArgumentException('Statut de commande non valide');
        }
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<ArticleCommand>
     */
    public function getArticleCommands(): Collection
    {
        return $this->articleCommands;
    }

    public function addarticleCommand(articleCommand $articleCommand): static
    {
        if (!$this->articleCommands->contains($articleCommand)) {
            $this->articleCommands->add($articleCommand);
            $articleCommand->setOrder($this);
        }

        return $this;
    }

    public function removearticleCommand(articleCommand $articleCommand): static
    {
        if ($this->articleCommands->removeElement($articleCommand)) {
            // set the owning side to null (unless already changed)
            if ($articleCommand->getOrder() === $this) {
                $articleCommand->setOrder(null);
            }
        }

        return $this;
    }

    public function getExpectedDeliveryDate(): ?DateTimeImmutable
    {
        return $this->expectedDeliveryDate;
    }

    public function setExpectedDeliveryDate(?DateTimeImmutable $expectedDeliveryDate): static
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;

        return $this;
    }

    public function getDeliveryUrl(): ?string
    {
        return $this->deliveryUrl;
    }

    public function setDeliveryUrl(?string $deliveryUrl): static
    {
        $this->deliveryUrl = $deliveryUrl;

        return $this;
    }
}
