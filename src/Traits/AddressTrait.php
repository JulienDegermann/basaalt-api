<?php

namespace App\Traits;

use App\Entity\City;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait AddressTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true, unique: false)]
    #[Groups(['read:live', 'read:lives', 'write:live', 'read:users', 'write:users', 'read:orders', 'write:order'])]
    private ?string $address;

    // #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'addresses')]
    // private ?City $city;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress($address): static
    {
        $this->address = $address;

        return $this;
    }

    // public function getCity(): ?City
    // {
    //     return $this->city;
    // }

    // public function setCity(?City $city): static
    // {
    //     $this->city = $city;

    //     return $this;
    // }
}