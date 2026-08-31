<?php

namespace App\DTO;

readonly class CommandeDTO
{
    private float $prixFinal;
    private bool $reductionAppliquee;

    public function __construct(float $prixFinal, bool $reductionAppliquee = false)
    {
        $this->prixFinal = $prixFinal;
        $this->reductionAppliquee = $reductionAppliquee;
    }

    public function getPrixFinal(): float
    {
        return $this->prixFinal;
    }

    public function isReductionAppliquee(): bool
    {
        return $this->reductionAppliquee;
    }
}
