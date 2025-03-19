<?php

namespace App\Entity;

use App\Repository\PatternRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatternRepository::class)]
class Pattern
{
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



    // Créateur du patron
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please provide the creator of the pattern !')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Minimum {{ limit }} characters please!',
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    #[Assert\Regex(
        pattern: '/^[a-z0-9_-]+$/i',
        message: 'Please  use only letters, numbers, underscores and dashes!'
    )]
    private ?string $author = null;

    // Boolean : patron est imprimé ou non
    #[ORM\Column]
    private ?bool $isPrinted = null;

    // Date de réalisation du patron
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateProduced = null;

    // Commentaire
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 5,
        max: 5000,
        minMessage: 'Minimum {{ limit }} characters please!',
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    private ?string $commentary = null;

    #[ORM\ManyToOne(inversedBy: 'pattern')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Category $category = null;

    public function __construct()
    {

        $this->dateProduced = new \DateTimeImmutable();
        $this->isPrinted = false;
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



    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function GetIsPrinted(): ?bool
    {
        return $this->isPrinted;
    }

    public function SetIsPrinted(bool $isPrinted): static
    {
        $this->isPrinted = $isPrinted;
        return $this;
    }

    public function getDateProduced(): ?\DateTimeImmutable
    {
        return $this->dateProduced;
    }

    public function setDateProduced(?\DateTimeImmutable $dateProduced): static
    {
        $this->dateProduced = $dateProduced;
        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): static
    {
        $this->commentary = $commentary;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }
}
