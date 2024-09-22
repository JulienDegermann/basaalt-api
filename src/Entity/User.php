<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use App\Traits\AddressTrait;
use App\Traits\DateEntityTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['read:user', 'read:users', 'read:date']],
    denormalizationContext: ['groups' => ['write:user', 'write:message']],
)
]
#[ApiFilter(SearchFilter::class, properties: ['email' => 'exact'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // createdAt and updatedAt properties, getters and setters
    use DateEntityTrait;
    use AddressTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:user', 'read:users', 'read:band', 'read:bands', 'read:messages', 'read:message', 'read:orders', 'read:order'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['read:user', 'read:band', 'write:message', 'read:message', 'read:messages', 'read:orders', 'read:order'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Email requis'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Email invalide : doit être une chaîne de caractères'
        ),
        new Assert\Length(
            min: 5,
            max: 180,
            minMessage: 'Email invalide : doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Email invalide : doit contenir au maximum {{ limit }} caractères'
        ),
        new Assert\Regex(
            pattern: '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-]+)*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)$/',
            message: 'E-mail invalide : contient des caractères non autorisés'
        ),
    ])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read:users', 'read:user'])]
    private array $roles;

    /**
     * @var ?string The hashed password
     */
    #[ORM\Column(nullable: true)]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Mot de passe invalide : doit être une chaîne de caractères'
        ),
        new Assert\Length(
            min: 12,
            max: 255,
            minMessage: 'Mot de passe invalide : doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Mot de passe invalide : doit contenir au maximum {{ limit }} caractères'
        ),
        new Assert\Regex(
            pattern: '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{12,255}$/',
            message: 'Mot de passe invalide : doit contenir au minimum 1 lettre majuscule, 1 lettre minuscule, 1 chiffre et 1 caractère spécial.'
        ),
    ])]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:users', 'read:user', 'read:bands', 'read:band', 'read:messages', 'write:user', 'write:message', 'read:message', 'read:orders', 'read:order'])]
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

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:users', 'read:user', 'read:messages', 'read:message', 'write:message', 'read:orders', 'read:order'])]
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

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:users', 'read:user', 'read:comments', 'read:comment', 'write:comment'])]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Pseudo invalide : doit être une chaîne de caractères'
        ),
        new Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Pseudo invalide : doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Pseudo invalide : doit contenir au maximum {{ limit }} caractères'
        ),
        new Assert\Regex(
            pattern: '/^[a-zA-Z0-9\-\p{L}]{2,255}$/u',
            message: 'Pseudo invalide : contient des caractères non autorisés'
        ),
    ])]
    private ?string $userName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:user', 'read:bands', 'read:band'])]
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

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:user', 'read:bands', 'read:band', 'write:band'])]
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

    #[ORM\ManyToOne(inversedBy: 'bandMember')]
    #[Groups(['read:user', 'write:user', 'read:user', 'write:band'])]
    #[Assert\Valid]
    private ?Band $band = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author', cascade: ['remove', 'persist'], orphanRemoval: true)]
    #[Groups(['read:user'])]
    #[Assert\Valid]
    private Collection $messages;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'author', cascade: ['remove', 'persist'], orphanRemoval: true)]
    #[Groups(['read:user'])]
    #[Assert\Valid]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'buyer', cascade: ['remove', 'persist'], orphanRemoval: true)]
    private Collection $orders;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->orders = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): static
    {
        $this->userName = $userName;

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

    public function getBandRole(): ?string
    {
        return $this->bandRole;
    }

    public function setBandRole(?string $bandRole): static
    {
        $this->bandRole = $bandRole;

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
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->firstName && $this->lastName ? $this->firstName . ' ' . $this->lastName : $this->userName;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getorders(): Collection
    {
        return $this->orders;
    }
}
