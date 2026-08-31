<?php

declare(strict_types=1);

namespace App\DTO;

readonly class CommandeDTO
{
    public function __construct(
        private float $montantInitial,
        private ?string $codePromo = null
    ) {
    }

    public function getMontantInitial(): float
    {
        return $this->montantInitial;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }
}
