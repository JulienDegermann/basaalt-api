<?php

namespace App\Traits;

use App\Entity\City;
use Doctrine\ORM\Mapping as ORM;

trait AddressTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true, unique: false)]
    private ?string $address;
    #[ORM\ManyToOne(inversedBy: 'addresses')]
    private ?City $city;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress($address): static
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
}