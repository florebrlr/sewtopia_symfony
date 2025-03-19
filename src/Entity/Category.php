<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(fields: ['name'])]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank]
    private ?string $name = null;

    /**
     * @var Collection<int, Pattern>
     */
    #[ORM\OneToMany(targetEntity: Pattern::class, mappedBy: 'category')]
    private Collection $patterns;

    public function __construct()
    {
        $this->patterns = new ArrayCollection();
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

    /**
     * @return Collection<int, Pattern>
     */
    public function getPatterns(): Collection
    {
        return $this->patterns;
    }

    public function addPattern(Pattern $pattern): static
    {
        if (!$this->patterns->contains($pattern)) {
            $this->patterns->add($pattern);
            $pattern->setCategory($this);
        }

        return $this;
    }

    public function removePattern(Pattern $pattern): static
    {
        if ($this->patterns->removeElement($pattern)) {
            // set the owning side to null (unless already changed)
            if ($pattern->getCategory() === $this) {
                $pattern->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }


}