<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'band:item']),
        new GetCollection(normalizationContext: ['groups' => 'band:list'])
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['band:list', 'band:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['band:list', 'band:item'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['band:list', 'band:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['band:list', 'band:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['band:list', 'band:item'])]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['band:list', 'band:item'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['band:list', 'band:item'])]
    private ?string $genre = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'band')]
    #[Groups(['band:list', 'band:item'])]
    private Collection $bandMember;

    #[ORM\OneToMany(targetEntity: Album::class, mappedBy: 'band')]
    #[Groups(['band:list', 'band:item'])]
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
}
