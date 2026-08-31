<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use App\DTO\CommandeDTO;
use App\Entity\Commande;
use App\Repository\CommandeRepository;

$donneesClient = [
    'prix_final' => 15000.0,
    'reduction_appliquee' => true,
];

$commandeDTO = new CommandeDTO(
    $donneesClient['prix_final'],
    $donneesClient['reduction_appliquee']
);

$commande = new Commande(
    $commandeDTO->getPrixFinal(),
    $commandeDTO->isReductionAppliquee()
);

$database = new Database();
$repository = new CommandeRepository($database);
$succes = $repository->save($commande);

if ($succes) {
    echo "\n=======================================================\n";
    echo "            COMMANDE ENREGISTRÉE AVEC SUCCÈS           \n";
    echo "=======================================================\n";
    echo sprintf(" Commande N°         : #%d\n", $commande->getId());
    echo sprintf(" Date de création    : %s\n", $commande->getDateCreation()?->format('d/m/Y H:i:s') ?? 'N/A');
    echo sprintf(" Prix final          : %10.2f FCFA\n", $commande->getPrixFinal());
    echo sprintf(" Réduction appliquée : %s\n", $commande->isReductionAppliquee() ? 'OUI' : 'NON');
    echo "=======================================================\n\n";
} else {
    echo "\n[Erreur] Impossible d'enregistrer la commande.\n\n";
}
