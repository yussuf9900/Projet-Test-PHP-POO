<?php

namespace App\Repository;

use App\Entity\Commande;

class CommandeRepository
{
    private \PDO $pdo;

    public function __construct(?\PDO $pdo = null)
    {
        if ($pdo !== null) {
            $this->pdo = $pdo;
        } else {
            $host ='localhost';
            $port = '5433';
            $dbname = 'ecommercegestion';
            $user = 'ichigo';
            $password = 'password';

            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
            $this->pdo = new \PDO($dsn, $user, $password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }
    }

    public function save(Commande $commande): bool
    {
        $sql = "INSERT INTO commande (prix_final, reduction_appliquee, date_creation) 
                VALUES (:prix_final, :reduction_appliquee, :date_creation) 
                RETURNING id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':prix_final', $commande->getPrixFinal());
        $stmt->bindValue(':reduction_appliquee', $commande->isReductionAppliquee(), \PDO::PARAM_BOOL);
        $stmt->bindValue(':date_creation', $commande->getDateCreation()?->format('Y-m-d H:i:s'));

        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result && isset($result['id'])) {
            $commande->setId((int) $result['id']);
            return true;
        }

        return false;
    }

    public function findById(int $id): ?Commande
    {
        $stmt = $this->pdo->prepare("SELECT * FROM commande WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $dateCreation = isset($data['date_creation']) ? new \DateTimeImmutable($data['date_creation']) : null;
        return new Commande(
            (float) $data['prix_final'],
            (bool) $data['reduction_appliquee'],
            (int) $data['id'],
            $dateCreation
        );
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM commande ORDER BY id ASC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $commandes = [];

        foreach ($rows as $data) {
            $dateCreation = isset($data['date_creation']) ? new \DateTimeImmutable($data['date_creation']) : null;
            $commandes[] = new Commande(
                (float) $data['prix_final'],
                (bool) $data['reduction_appliquee'],
                (int) $data['id'],
                $dateCreation
            );
        }

        return $commandes;
    }
}
