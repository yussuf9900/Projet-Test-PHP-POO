<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CommandeDTO;
use App\Entity\Commande;
use App\Repository\CommandeRepository;

class CommandeService
{
    public const CODE_PROMO_VALIDE = 'REDUC10';
    public const TAUX_REDUCTION = 0.10;

    private CommandeRepository $repository;

    public function __construct(CommandeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function passerCommande(CommandeDTO $dto): Commande
    {
        $montantInitial = $dto->getMontantInitial();

        if ($montantInitial <= 0) {
            throw new \InvalidArgumentException("Le montant de la commande doit être supérieur à 0.");
        }

        $reductionAppliquee = $this->verifierCodePromo($dto->getCodePromo());
        $remise = $reductionAppliquee ? ($montantInitial * self::TAUX_REDUCTION) : 0.0;
        $prixFinal = $montantInitial - $remise;

        $commande = new Commande(
            prixFinal: $prixFinal,
            reductionAppliquee: $reductionAppliquee
        );

        $succes = $this->repository->save($commande);

        if (!$succes) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de la commande en BDD.");
        }

        return $commande;
    }

    public function creerCommande(CommandeDTO $dto): Commande
    {
        return $this->passerCommande($dto);
    }

    public function verifierCodePromo(?string $codePromo): bool
    {
        if ($codePromo === null) {
            return false;
        }

        return strtoupper(trim($codePromo)) === self::CODE_PROMO_VALIDE;
    }

    public function getRepository(): CommandeRepository
    {
        return $this->repository;
    }
}
