<?php
namespace App\Models;

use PDO;

class Animal
{
    private static function db(): PDO
    {
        $config = require __DIR__ . '/../../config/database.php';
        return new PDO($config['dsn'], $config['user'], $config['pass']);
    }

    public static function all(): array
    {
        $stmt = self::db()->query("SELECT * FROM animals");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM animals WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function create(array $data): array
    {
        $stmt = self::db()->prepare("INSERT INTO animals (name, species, age) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['species'], $data['age']]);
        return ['id' => self::db()->lastInsertId()] + $data;
    }
}
