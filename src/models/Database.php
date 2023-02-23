<?php

namespace App\models;

use PDO;

require __DIR__.'/../../config/config_db.php';

class Database
{
    private $pdo;

    public function connect()
    {
        $connect_str = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
        $pdo = new PDO($connect_str, DB_USER, DB_PASSWORD);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT id, title, author, book_description FROM books";
        $this->connect();

        $stmt = $this->pdo->query($sql);

        $this->pdo = null;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $sql = "SELECT id, title, author, book_description FROM books WHERE id = $id";
        $this->connect();

        $stmt = $this->pdo->query($sql);

        $this->pdo = null;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
