<?php

namespace App\DTO;

class CommandeDTO
{
    private array $panier;
    private ?string $codePromo;

    public function __construct(array $panier = [], ?string $codePromo = null)
    {
        $this->panier = $panier;
        $this->codePromo = $codePromo;
    }

    public function getPanier(): array
    {
        return $this->panier;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }
}
