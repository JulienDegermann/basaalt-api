<?php

namespace App\Entity;

use App\Repository\SongLinksRepository;
use App\Traits\DateEntityTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongLinksRepository::class)]
class SongLinks
{
    // use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plateform $plateform = null;

    #[ORM\ManyToOne(inversedBy: 'songLinks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Song $song = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getPlateform(): ?Plateform
    {
        return $this->plateform;
    }

    public function setPlateform(?Plateform $plateform): static
    {
        $this->plateform = $plateform;

        return $this;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): static
    {
        $this->song = $song;

        return $this;
    }

    public function __toString(): string
    {
        return $this->plateform->getName();
    }
}
