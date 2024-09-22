<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StockRepository;
use App\Traits\ColorTrait;
use App\Traits\DateEntityTrait;
use App\Traits\QuantityTrait;
use App\Traits\SizeTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StockRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'stock:item']),
        new GetCollection(normalizationContext: ['groups' => 'stock:list']),
    ],
    normalizationContext: ['groups' => ['read:stocks', 'read:stock', 'read:articles']],
    denormalizationContext: ['groups' => ['stock:write']],
    order: ['year' => 'DESC', 'city' => 'ASC'],
    paginationEnabled: false,
)]
class Stock
{
    use DateEntityTrait;
    use QuantityTrait;
    use SizeTrait;
    use ColorTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:date'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:stocks', 'read:stock', 'write:order'])]
    #[Assert\Valid]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Order $orders = null;

    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:article', 'read:date'])]
    #[ORM\OneToMany(targetEntity: StockImages::class, mappedBy: 'stock', cascade: ['persist', 'remove'], orphanRemoval: true,)]
    private Collection $stockImages;

    #[ORM\OneToMany(targetEntity: ArticleCommand::class, mappedBy: 'stock', cascade: ['persist'], orphanRemoval: true)]
    private Collection $articleCommands;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->stockImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getArticle()->getName() . " (taille : $this->size, en stock : $this->quantity . )";
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * @return Collection<int, StockImages>
     */
    public function getStockImages(): Collection
    {
        return $this->stockImages;
    }

    public function addStockImage(StockImages $stockImage): static
    {
        if (!$this->stockImages->contains($stockImage)) {
            $this->stockImages->add($stockImage);
            $stockImage->setStock($this);
        }

        return $this;
    }

    public function removeStockImage(StockImages $stockImage): static
    {
        if ($this->stockImages->removeElement($stockImage)) {
            // set the owning side to null (unless already changed)
            if ($stockImage->getStock() === $this) {
                $stockImage->setStock(null);
            }
        }

        return $this;
    }

    public function addArticle(ArticleCommand $articleCommand): static
    {
        if (!$this->articleCommands->contains($articleCommand)) {
            $this->add($articleCommand);
        }
        $articleCommand->setStock($this);

        return $this;
    }

    public function removeArticle(ArticleCommand $articleCommand): static
    {
        if ($this->articleCommands->remove($articleCommand)) {
            if ($articleCommand->getStock() === $this) {
                $articleCommand->setStock(null);
            }
        }

        return $this;
    }

    public function getArticleCommands(): Collection
    {
        return $this->articleCommands;
    }
}
