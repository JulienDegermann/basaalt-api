<?php

namespace App\Entity;

use App\Entity\Band;
use App\Entity\Song;
use App\Entity\Plateform;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AlbumRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:album', 'read:albums']],
    denormalizationContext: ['groups' => ['write:album']],
    operations:[
        new Get(),
        new GetCollection(),
        new Put(),
        new Post(),
        new Delete()
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['read:album', 'read:albums'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read:album', 'read:albums'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:album', 'read:albums'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform'])]
    private ?\DateTimeImmutable $releasedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform'])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:album', 'read:albums'])]
    private ?Band $band = null;

    #[ORM\OneToMany(targetEntity: Song::class, mappedBy: 'album')]
    #[Groups(['read:album', 'read:albums'])]
    private Collection $songs;

    #[ORM\ManyToMany(targetEntity: Plateform::class, mappedBy: 'albums')]
    private Collection $plateforms;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->plateforms = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(?\DateTimeImmutable $releasedAt): static
    {
        $this->releasedAt = $releasedAt;

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

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): static
    {
        $this->band = $band;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): static
    {
        if (!$this->songs->contains($song)) {
            $this->songs->add($song);
            $song->setAlbum($this);
        }

        return $this;
    }

    public function removeSong(Song $song): static
    {
        if ($this->songs->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getAlbum() === $this) {
                $song->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plateform>
     */
    public function getPlateforms(): Collection
    {
        return $this->plateforms;
    }

    public function addPlateform(Plateform $plateform): static
    {
        if (!$this->plateforms->contains($plateform)) {
            $this->plateforms->add($plateform);
            $plateform->addAlbum($this);
        }

        return $this;
    }

    public function removePlateform(Plateform $plateform): static
    {
        if ($this->plateforms->removeElement($plateform)) {
            $plateform->removeAlbum($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
