<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OrderRepository;
use App\Traits\DateEntityTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete(),
        new Put()
    ],
    normalizationContext: ['groups' => ['read:orders', 'read:order', 'read:date']],
    denormalizationContext: ['groups' => ['write:order']],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Order
{
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:orders', 'read:order'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?UserOrder $userOrder = null;

    #[ORM\OneToMany(targetEntity: ArticleCommand::class, mappedBy: 'order', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $articleCommands;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->articleCommands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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
}
