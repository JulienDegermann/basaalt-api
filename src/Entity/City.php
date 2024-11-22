<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;


#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:cities']]),
    ],
    paginationEnabled: true,
    paginationItemsPerPage: 10
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial', 'zipCode' => 'partial'])]
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
    private Collection $liveCities;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'city')]
    private Collection $userCities;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'city')]
    private Collection $deliveryCities;


    // public function addAddress(Address $address): static
    // {
    //     $this->addresses->add($address);
    //     if (!$address->getCity()) {
    //         $address->setCity($this);
    //     }

    //     return $this;
    // }

    // public function removeAddress(Address $address): static
    // {
    //     if ($this->addresses->removeElement($address)) {
    //         $address->setCity(null);
    //     };

    //     return $this;
    // }

    public function __construct()
    {
        $this->liveCities = new ArrayCollection();
        $this->userCities = new ArrayCollection();
        $this->deliveryCities = new ArrayCollection();
    }

    public function getAdresses(): Collection
    {
        return $this->userCities;
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
    public function getLiveCities(): Collection
    {
        return $this->liveCities;
    }

    public function addLiveCity(Live $live): static
    {
        if (!$this->liveCities->contains($live)) {
            $this->liveCities->add($live);
            $live->setCity($this);
        }

        return $this;
    }

    public function removeLive(Live $live): static
    {
        if ($this->liveCities->removeElement($live)) {
            // set the owning side to null (unless already changed)
            if ($live->getCity() === $this) {
                $live->setCity(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return strtoupper($this->name) . " (" . $this->zipCode . ")";
    }
}
