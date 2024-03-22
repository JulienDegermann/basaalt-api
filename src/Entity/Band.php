<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Album;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BandRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: BandRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:bands', 'read:band']],
    denormalizationContext: ['groups' => 'write:band'],
    operations:[
        new Get(),
        new GetCollection(),
        new Put()
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:band', 'read:bands', 'read:albums'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:bands', 'read:band', 'write:band', 'read:albums'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['read:band'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read:band'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:band', 'read:bands', 'write:band'])]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:band', 'read:bands', 'write:band'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:band', 'read:bands', 'write:band', 'read:albums'])]
    private ?string $genre = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'band')]
    #[Groups(['read:band', 'read:bands', 'write:band'])]
    private Collection $bandMember;

    #[ORM\OneToMany(targetEntity: Album::class, mappedBy: 'band')]
    #[Groups(['read:band', 'read:bands'])]
    private Collection $albums;

    public function __construct()
    {
        $this->bandMember = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getBandMember(): Collection
    {
        return $this->bandMember;
    }

    public function addBandMember(User $bandMember): static
    {
        if (!$this->bandMember->contains($bandMember)) {
            $this->bandMember->add($bandMember);
            $bandMember->setBand($this);
        }

        return $this;
    }

    public function removeBandMember(User $bandMember): static
    {
        if ($this->bandMember->removeElement($bandMember)) {
            // set the owning side to null (unless already changed)
            if ($bandMember->getBand() === $this) {
                $bandMember->setBand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setBand($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getBand() === $this) {
                $album->setBand(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
