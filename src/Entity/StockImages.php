<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\StockImagesRepository;
use App\Traits\DateEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: StockImagesRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:stocks', 'read:stock', 'read:articles', 'read:article']],
    denormalizationContext: ['groups' => ['write:stock']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)] class StockImages
{
    use DateEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:stocks', 'read:stock'])]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'article', fileNameProperty: 'fileName', size: 'fileSize')]
    #[
        Assert\Sequentially(
            [
                new Assert\Image(
                    maxSize: '5M',
                    maxSizeMessage: 'Image invalide : {{ max }}  maximum',
                    mimeTypes: ['image/jpeg'],
                    mimeTypesMessage: 'Image invalide : formats acceptés jpeg',
                ),
            ]
        )
    ]
    private ?File $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:article'])]
    #[
        Assert\Sequentially(
            [
                new Assert\Image(
                    maxSize: '5M',
                    maxSizeMessage: 'Image invalide : {{ max }}  maximum',
                    // 'mimeTypes' => ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'],
                    mimeTypes: ['image/jpeg'],
                    mimeTypesMessage: 'Image invalide : formats acceptés jpeg',
                // 'mimeTypesMessage' => 'Image invalide : formats ±acceptés jpeg, jpg, png, gif',
                ),
            ]
        )
    ]
    private ?string $fileName = null;

    private ?int $fileSize = null;

    #[ORM\ManyToOne(inversedBy: 'articleImages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    private ?Stock $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

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

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function __toString(): string
    {
        return $this->fileName ? $this->fileName : '';
    }
}
