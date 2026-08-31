<?php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $port = '5433';
        $dbname = 'ecommercegestion';
        $user = 'ichigo';
        $password = 'password';

        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Erreur de connexion BDD : " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
