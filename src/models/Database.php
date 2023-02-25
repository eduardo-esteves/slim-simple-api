<?php

namespace App\models;

use PDO;

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

    public function getAll(): array
    {
        $sql = "SELECT id, title, author, book_description FROM books";
        $this->connect();

        $stmt = $this->pdo->query($sql);

        $this->pdo = null;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array
    {
        $sql = "SELECT id, title, author, book_description FROM books WHERE id = $id";
        $this->connect();

        $stmt = $this->pdo->query($sql);

        $this->pdo = null;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Book $book): int
    {
        $sql = "INSERT INTO books VALUES (default, :title, :author, :book_description)";
        $this->connect();

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array(
            ":title" => $book->__get('title'),
            ":author" => $book->__get('author'),
            ":book_description" => $book->__get('book_description'),
            )
        );

        return $this->pdo->lastInsertId();
    }
}
