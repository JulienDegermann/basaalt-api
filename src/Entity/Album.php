<?php

namespace App\Entity;

use App\Entity\Band;
use App\Entity\Song;
use App\Entity\Plateform;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use App\Traits\DateEntityTrait;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AlbumRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:album', 'read:albums', 'read:date']],
    denormalizationContext: ['groups' => ['write:album']],
    operations: [
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
    // createdAt and updatedAt properties, getters and setters
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform', 'read:songs', 'read:song'])]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform', 'read:songs', 'read:song'])]
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
            pattern: '/^[a-zA-Z0-9\s\-#]{1,255}+$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:album', 'read:albums'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Ce champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Ce champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z0-9\s\-\(\)\'\".,:\p{L}]{5,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $description = null;

    #[Assert\Image(
        allowLandscape: true,
        allowPortrait: true,
        maxSize: '5M',
        maxSizeMessage: 'Le fichier est trop volumineux. La taille maximale autorisée est de {{ limit }} Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'],
        mimeTypesMessage: 'Le format de l\'image n\'est pas valide. Les formats valides sont {{ types }}.'
    )]
    private ?File $file = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'datetimeimmutable',
            message: 'Ce champ doit être une date valide.'
        ),
        new Assert\LessThanOrEqual(
            value: 'today',
            message: 'La date de sortie ne peut pas être postérieure à la date du jour.'
        )
    ])]
    private ?\DateTimeImmutable $releasedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:album', 'read:albums', 'read:band', 'read:bands', 'read:plateform'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Ce champ est obligatoire.'
        ),
        new Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Ce champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Ce champ est limité à {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^.+\.(jpg|jpeg|png|webp)$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:album', 'read:albums'])]
    #[Assert\Valid]
    private ?Band $band = null;

    #[ORM\OneToMany(targetEntity: Song::class, mappedBy: 'album')]
    #[Groups(['read:album', 'read:albums'])]
    #[Assert\Valid]
    private Collection $songs;

    #[ORM\ManyToMany(targetEntity: Plateform::class, mappedBy: 'albums')]
    #[Assert\Valid]
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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): static
    {
        $this->file = $file;

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
