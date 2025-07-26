<?php

namespace App\Entity;

use DateTimeImmutable;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Traits\DateEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\BandMemberRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BandMemberRepository::class)]
#[Vich\Uploadable]
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
class BandMember
{
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:band', 'read:bands', 'read:albums'])]
    private ?int $id;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:band', 'read:bands'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Nom requis'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Nom invalide : doit être une chaîne de caractères'
        ),
        new Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Nom invalide : doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Nom invalide : doit contenir au maximum {{ limit }} caractères'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z\s\-\p{L}]{2,255}$/u',
            message: 'Nom invalide : contient des caractères non autorisés'
        ),
    ])]
    private ?string $lastName = null;


    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['read:band', 'read:bands'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Prénom requis'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Prénom invalide : doit être une chaîne de caractères'
        ),
        new Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Prénom invalide : doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Prénom invalide : doit contenir au maximum {{ limit }} caractères'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z\s\-\p{L}]{2,255}$/u',
            message: 'Prénom invalide : contient des caractères non autorisés'
        ),
    ])]
    private ?string $firstName = null;

    #[Vich\UploadableField(mapping: 'bandMember', fileNameProperty: 'image', size: 'fileSize')]
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
    #[Groups(['read:band', 'read:bands'])]
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

    private ?int $fileSize = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:band', 'read:bands'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Rôle invalide : doit être une chaîne de caractères'
        ),
        new Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Rôle invalide : doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Rôle invalide : doit contenir au maximum {{ limit }} caractères'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z\s\-\p{L}]{2,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        ),
    ])]
    private ?string $bandRole = null;


    #[ORM\Column(nullable: true)]
    #[Groups(['read:band', 'read:bands'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'datetimeimmutable',
            message: 'Date invalide'
        ),
        new Assert\LessThanOrEqual(
            value: 'now  - 18 years',
            message: 'Vous devez être majeur pour créer un compte.'
        ),
    ])]
    private ?DateTimeImmutable $birthDate = null;


    #[ORM\ManyToOne(inversedBy: 'bandMember')]
    #[Assert\Valid]
    private ?Band $band = null;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBandRole(): ?string
    {
        return $this->bandRole;
    }

    public function setBandRole(?string $bandRole): static
    {
        $this->bandRole = $bandRole;

        return $this;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeImmutable $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): static
    {
        $this->band = $band;
        if ($band !== null && !$band->getBandMember()->contains($this)) {
            $band->addBandMember($this);
        }

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        if ($file !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): static
    {
        $this->fileSize = $fileSize;

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

    public function __toString(): string
    {
        return $this->firstName;
    }
}
