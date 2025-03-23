<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use App\Traits\DateEntityTrait;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SongRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:songs', 'read:song']],
    denormalizationContext: ['groups' => ['write:song']],
    operations: [
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
    // createdAt and updatedAt properties, getters and setters
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:song', 'read:songs', 'read:plateform', 'read:songs', 'read:song', 'read:albums', 'read:album', 'read:date'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:song', 'read:songs', 'read:plateform', 'read:albums', 'read:album', 'write:song'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Ce champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Ce champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z0-9\s\-#]{1,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:song', 'write:song')]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Ce champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Ce champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z0-9\s\-\(\)\'\".,:x\p{L}]{1,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $description = null;
    
    #[ORM\Column(nullable: true)]
    #[Groups(['read:song', 'read:song', 'read:album', 'write:song'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'datetimeimmutable',
            message: 'Ce champ doit être une date valide.'
        )
    ])]
    private ?\DateTimeImmutable $releasedAt = null;

    #[ORM\ManyToOne(inversedBy: 'songs')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['read:song', 'write:song', 'read:songs'])]
    #[Assert\Valid]
    private ?Album $album = null;

    #[ORM\OneToMany(targetEntity: SongLinks::class, mappedBy: 'song', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $songLinks;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->songLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @return Collection<int, SongLinks>
     */
    public function getSongLinks(): Collection
    {
        return $this->songLinks;
    }

    public function addSongLink(SongLinks $songLink): static
    {
        if (!$this->songLinks->contains($songLink)) {
            $this->songLinks->add($songLink);
            $songLink->setSong($this);
        }

        return $this;
    }

    public function removeSongLink(SongLinks $songLink): static
    {
        if ($this->songLinks->removeElement($songLink)) {
            // set the owning side to null (unless already changed)
            if ($songLink->getSong() === $this) {
                $songLink->setSong(null);
            }
        }

        return $this;
    }
}
