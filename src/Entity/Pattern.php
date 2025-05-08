<?php

namespace App\Entity;

use App\Repository\PatternRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatternRepository::class)]
class Pattern
{
    // ID
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Titre
    #[ORM\Column(length: 250)]
    #[Assert\NotBlank(message: 'Please provide a pattern  !')]
    #[Assert\Length(
        min: 5,
        max: 5000,
        minMessage: 'Minimum {{ limit }} characters please!',
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    private ?string $title = null;

    // Créatrice.teur du patron
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please provide the creator of the pattern !')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Minimum {{ limit }} characters please!',
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
//    #[Assert\Regex(
//        pattern: '/^[a-z0-9_-]+$/i',
//        message: 'Please  use only letters, numbers, underscores and dashes!'
//    )]
    private ?string $author = null;

    // Boolean : patron est imprimé ou non
    #[ORM\Column]
    private ?bool $isPrinted = null;

    // Boolean : projet réalisé oui ou non
    #[ORM\Column(nullable: false)]
    private ?bool $isRealized = false;

    // Date de réalisation du patron
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateRealized = null;

    // Commentaire
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 5,
        max: 5000,
        minMessage: 'Minimum {{ limit }} characters please!',
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    private ?string $commentary = null;

    // Relation pattern - category
    #[ORM\ManyToOne(inversedBy: 'pattern')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Category $category = null;

    //image
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    //relation pattern - user
    #[ORM\ManyToOne(inversedBy: 'patterns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->isPrinted = false;
        $this->dateRealized = null;
    }

    // Getter et setter ID
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter et setter title
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    // Getter et setter author
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    // Getter et setter isPrinted
    public function getIsPrinted(): ?bool
    {
        return $this->isPrinted;
    }

    public function setIsPrinted(bool $isPrinted): static
    {
        $this->isPrinted = $isPrinted;
        return $this;
    }

    // Getter et setter isRealized
    public function getIsRealized(): ?bool
    {
        return $this->isRealized;
    }

    public function setIsRealized(?bool $isRealized): static
    {
        $this->isRealized = $isRealized;
        return $this;
    }

    // Getter et setter dateRealized
    public function getDateRealized(): ?\DateTimeImmutable
    {
        return $this->dateRealized;
    }

    public function setDateRealized(?\DateTimeImmutable $dateRealized): static
    {
        if ($this->isRealized) {
            $this->dateRealized = $dateRealized;
        } else {
            $this->dateRealized = null; // Si le projet n'est pas réalisé, on garde la date à null.
        }
        return $this;
    }

    // Getter et setter commentary
    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): static
    {
        if (!$this->isRealized) {
            $commentary = null; // Si le projet n'est pas réalisé, on garde le commentaire à null.
        }
        $this->commentary = $commentary;
        return $this;
    }

    // Getter et setter category
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    // Getter et setter image
    public function getImage(): ?string
    {
        return $this->image;
    }
    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
