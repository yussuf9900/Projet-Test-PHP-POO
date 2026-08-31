<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use App\DTO\CommandeDTO;
use App\Repository\CommandeRepository;
use App\Service\CommandeService;

$database = new Database();
$repository = new CommandeRepository($database);
$service = new CommandeService($repository);

$dtoAvecPromo = new CommandeDTO(15000.0, 'REDUC10');
$commande1 = $service->passerCommande($dtoAvecPromo);

$dtoSansPromo = new CommandeDTO(15000.0, null);
$commande2 = $service->passerCommande($dtoSansPromo);

echo "\n=======================================================\n";
echo "            COMMANDE 1 (AVEC CODE PROMO)               \n";
echo "=======================================================\n";
echo sprintf(" Commande N°         : #%d\n", $commande1->getId());
echo sprintf(" Date de création    : %s\n", $commande1->getDateCreation()?->format('d/m/Y H:i:s') ?? 'N/A');
echo sprintf(" Prix final          : %10.2f FCFA\n", $commande1->getPrixFinal());
echo sprintf(" Réduction appliquée : %s\n", $commande1->isReductionAppliquee() ? 'OUI (-10%)' : 'NON');
echo "=======================================================\n\n";

echo "=======================================================\n";
echo "            COMMANDE 2 (SANS CODE PROMO)               \n";
echo "=======================================================\n";
echo sprintf(" Commande N°         : #%d\n", $commande2->getId());
echo sprintf(" Date de création    : %s\n", $commande2->getDateCreation()?->format('d/m/Y H:i:s') ?? 'N/A');
echo sprintf(" Prix final          : %10.2f FCFA\n", $commande2->getPrixFinal());
echo sprintf(" Réduction appliquée : %s\n", $commande2->isReductionAppliquee() ? 'OUI (-10%)' : 'NON');
echo "=======================================================\n\n";
