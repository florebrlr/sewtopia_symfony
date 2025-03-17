<?php

namespace App\Entity;

use App\Repository\WishRepository;
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

    //titre
    #[ORM\Column(length: 250)]
    #[Assert\NotBlank(message: 'Please provide a pattern  !')]
    #[Assert\Length(
        min:5,
        minMessage: 'Minimum {{ limit }} characters please!',
        max: 5000,
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    private ?string $title = null;

    //Commentaire
    #[ORM\Column(type: Types::TEXT, nullable: true)]

    #[Assert\Length(
        min:5,
        minMessage: 'Minimum {{ limit }} characters please!',
        max: 5000,
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    private ?string $commentary = null;

    //créateur du patron
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please provide the creator of the pattern !')]
    #[Assert\Length(
        min:3,
        minMessage: 'Minimum {{ limit }} characters please!',
        max: 50,
        maxMessage: 'Maximum {{ limit }} characters please!'
    )]
    #[Assert\Regex(
        pattern: '/^[a-z0-9_-]+$/i',
        message: 'Please  use only letters, numbers,underscores and dashes!'
    )]
    private ?string $author = null;

    //boolean patron est imprimé ou non
    #[ORM\Column]
    private ?bool $isPrinted = null;

    // date de réalisation du patron
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateProduced = null;

    public function __construct()
    {
        $this->$dateProduced = new \DateTimeImmutable();
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

    public function getDescription(): ?string
    {
        return $this->commentary;
    }

    public function setDescription(?string $commentary): static
    {
        $this->commentary = $commentary;

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

    public function isPublished(): ?bool
    {
        return $this->isPrinted;
    }

    public function setIsPublished(bool $isPrinted): static
    {
        $this->isPrinted = $isPrinted;

        return $this;
    }


    public function getDateProduced(): ?\DateTimeImmutable
    {
        return $this->getDateProduced;
    }

    public function setDateUpdated(?\DateTimeImmutable $dateProduced): static
    {
        $this->getDateProduced = $dateProduced;
        return $this;
    }
}
