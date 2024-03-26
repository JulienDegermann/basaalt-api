<?php

namespace App\Entity;

use App\Entity\Live;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CityRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:cities']]),
    ],

)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:cities', 'read:lives', 'read:live'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:cities', 'read:lives', 'read:live'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:cities', 'read:lives', 'read:live'])]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $inseeCode = null;

    #[ORM\OneToMany(targetEntity: Live::class, mappedBy: 'city')]
    private Collection $lives;

    public function __construct()
    {
        $this->lives = new ArrayCollection();
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

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getInseeCode(): ?string
    {
        return $this->inseeCode;
    }

    public function setInseeCode(string $inseeCode): static
    {
        $this->inseeCode = $inseeCode;

        return $this;
    }

    /**
     * @return Collection<int, Live>
     */
    public function getLives(): Collection
    {
        return $this->lives;
    }

    public function addLife(Live $life): static
    {
        if (!$this->lives->contains($life)) {
            $this->lives->add($life);
            $life->setCity($this);
        }

        return $this;
    }

    public function removeLife(Live $life): static
    {
        if ($this->lives->removeElement($life)) {
            // set the owning side to null (unless already changed)
            if ($life->getCity() === $this) {
                $life->setCity(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return strtoupper($this->name) ." (" . $this->zipCode .")";
    }
}
