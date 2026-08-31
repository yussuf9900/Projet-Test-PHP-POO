<?php

namespace App\Core;

abstract class AbstractEntity
{
    protected ?int $id;
    protected ?\DateTimeInterface $dateCreation;

    public function __construct(?int $id = null, ?\DateTimeInterface $dateCreation = null)
    {
        $this->id = $id;
        $this->dateCreation = $dateCreation ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }
}
