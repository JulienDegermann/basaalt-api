<?php

namespace App\Entity;

use App\Entity\Plateform;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SongRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:songs', 'read:song']],
    denormalizationContext: ['groups' => ['write:song']],
    operations:[
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete()
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,

)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read:plateform', 'read:songs', 'read:song', 'read:albums', 'read:album')]
    private ?int $id = null;
    
    #[ORM\Column]
    #[Groups('read:song')]
    private ?\DateTimeImmutable $createdAt = null;
    
    #[ORM\Column]
    #[Groups('read:song')]
    private ?\DateTimeImmutable $updatedAt = null;
    
    #[ORM\Column(length: 255)]
    #[Groups('read:songs', 'read:song', 'read:albums', 'read:album','read:plateform',  'write:song')]
    private ?string $title = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:song', 'write:song')]
    private ?string $description = null;
    
    #[ORM\Column(nullable: true)]
    #[Groups('read:song', 'write:song', 'read:album', 'read:songs')]
    private ?\DateTimeImmutable $releasedAt = null;
    
    #[ORM\ManyToOne(inversedBy: 'songs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read:song', 'write:song', 'read:songs', 'read:albums')]
    private ?Album $album = null;

    #[ORM\ManyToMany(targetEntity: Plateform::class, mappedBy: 'songs')]
    private Collection $plateforms;

    public function __construct()
    {
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

    public function setDescription(?string $description): static
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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

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
            $plateform->addSong($this);
        }

        return $this;
    }

    public function removePlateform(Plateform $plateform): static
    {
        if ($this->plateforms->removeElement($plateform)) {
            $plateform->removeSong($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
