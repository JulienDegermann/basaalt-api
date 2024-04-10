<?php

namespace App\Entity;

use App\Entity\Order;
use App\Traits\DateEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserOrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserOrderRepository::class)]
class UserOrder
{
    use DateEntityTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userOrders')]
    private ?User $buyer = null;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'userOrder', cascade: ['persist', 'remove'])]
    private Collection $orders;

    #[ORM\Column(length: 255)]
    private ?string $creditCard = null;

    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:orders', 'read:order'])]
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
            maxMessage: 'Ce champ est limité à {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z\s\p{L}]{2,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $status = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->totalPrice = 0;

        foreach($this->orders as $order) {
            $this->totalPrice += $order->getQuantity()*$order->getStock()->getPrice();
        }
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
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUserOrder($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUserOrder() === $this) {
                $order->setUserOrder(null);
            }
        }

        return $this;
    }

    public function getCreditCard(): ?string
    {
        return $this->creditCard;
    }

    public function setCreditCard(string $creditCard): static
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
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
}
