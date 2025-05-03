<?php

namespace App\Model;

class SearchData
{
    private int $page = 1;
    private string $search = '';
    private ?string $category = null;
    private ?string $author = null;
    private ?bool $isRealized = null;
    private ?\DateTimeInterface $dateRealizedFrom = null;
    private ?\DateTimeInterface $dateRealizedTo = null;
    private ?bool $isPrinted = null;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setSearch(string $search): self
    {
        $this->search = $search;
        return $this;
    }

    // Alias pour compatibilité : getSearchTerm() appelle getSearch()
    public function getSearchTerm(): string
    {
        return $this->getSearch();
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getIsRealized(): ?bool
    {
        return $this->isRealized;
    }

    public function setIsRealized(?bool $isRealized): self
    {
        $this->isRealized = $isRealized;
        return $this;
    }

    public function getDateRealizedFrom(): ?\DateTimeInterface
    {
        return $this->dateRealizedFrom;
    }

    public function setDateRealizedFrom(?\DateTimeInterface $dateRealizedFrom): self
    {
        $this->dateRealizedFrom = $dateRealizedFrom;
        return $this;
    }

    public function getDateRealizedTo(): ?\DateTimeInterface
    {
        return $this->dateRealizedTo;
    }

    public function setDateRealizedTo(?\DateTimeInterface $dateRealizedTo): self
    {
        $this->dateRealizedTo = $dateRealizedTo;
        return $this;
    }

    public function getIsPrinted(): ?bool
    {
        return $this->isPrinted;
    }

    public function setIsPrinted(?bool $isPrinted): self
    {
        $this->isPrinted = $isPrinted;
        return $this;
    }
}
