<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Album;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Traits\DateEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BandRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:bands', 'read:band', 'read:date']],
    denormalizationContext: ['groups' => 'write:band'],
    operations: [
        new Get(),
        new GetCollection(),
        new Put()
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Band
{
    // createdAt and updatedAt properties, getters and setters
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:band', 'read:bands', 'read:albums'])]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Groups(['read:bands', 'read:band', 'write:band', 'read:albums'])]
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
    private ?string $name;

    #[Assert\Image(
        allowLandscape: true,
        allowPortrait: true,
        maxSize: '5M',
        maxSizeMessage: 'Le fichier est trop volumineux. La taille maximale autorisée est de {{ limit }} Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'],
        mimeTypesMessage: 'Le format de l\'image n\'est pas valide. Les formats valides sont {{ types }}.'
    )]
    private ?File $file;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:band', 'read:bands', 'write:band'])]
    #[Assert\Sequentially([
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
    private ?string $image;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:band', 'read:bands', 'write:band'])]
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
    private ?string $description;

    #[ORM\Column(length: 255)]
    #[Groups(['read:band', 'read:bands', 'write:band', 'read:albums'])]
    private ?string $genre;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'band', cascade: ['persist', 'remove'])]
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
