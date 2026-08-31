<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\DTO\CommandeDTO;
use App\Entity\Commande;
use App\Repository\CommandeRepository;


$donneesClient = [
    'panier' => [
        ['id' => 1, 'nom' => 'Clavier mécanique', 'prix' => 7500, 'quantite' => 1],
        ['id' => 2, 'nom' => 'Souris sans fil', 'prix' => 2500, 'quantite' => 2],
    ],
    'code_promo' => 'REDUC10'
];

$commandeDTO = new CommandeDTO($donneesClient['panier'], $donneesClient['code_promo']);

$sousTotal = 0;
foreach ($commandeDTO->getPanier() as $item) {
    $sousTotal += $item['prix'] * $item['quantite'];
}

$tauxReduction = 0.0;
if ($commandeDTO->getCodePromo() === 'REDUC10') {
    $tauxReduction = 0.10;
}
$remise = $sousTotal * $tauxReduction;
$prixFinal = $sousTotal - $remise;
$reductionAppliquee = ($tauxReduction > 0);

$commande = new Commande($prixFinal, $reductionAppliquee);
$repository = new CommandeRepository();
$repository->save($commande);

echo "\n                      DÉTAILS COMMANDE                        \n\n";
echo sprintf(" Commande N°         : #%d\n", $commande->getId() ?? 0);
echo sprintf(" Date de création    : %s\n", $commande->getDateCreation()?->format('d/m/Y H:i:s') ?? 'N/A');
echo sprintf(" Code promo          : %s\n", $commandeDTO->getCodePromo() ?? 'Aucun');
echo sprintf(" Réduction appliquée : %s\n", $commande->isReductionAppliquee() ? 'OUI (' . ($tauxReduction * 100) . '%)' : 'NON');
echo "\n                      CONTENU DU PANIER                       \n\n";
echo sprintf(" %-24s | %-12s | %-8s | %-10s\n", "Article", "Prix unit.", "Quantité", "Sous-total");

foreach ($commandeDTO->getPanier() as $item) {
    $totalLigne = $item['prix'] * $item['quantite'];
    echo sprintf(
        " %-24s | %10.2f fcfa | %8d | %8.2f fcfa\n",
        $item['nom'],
        $item['prix'],
        $item['quantite'],
        $totalLigne
    );
}

echo sprintf(" Sous-total brut     : %10.2f fcfa\n", $sousTotal);
if ($reductionAppliquee) {
    echo sprintf(" Remise appliquée    : -%9.2f fcfa\n", $remise);
}
echo sprintf(" TOTAL FINAL À PAYER : %10.2f fcfa\n", $commande->getPrixFinal());

