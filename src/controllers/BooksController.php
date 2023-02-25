<?php

namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\models\Database;

class BooksController
{
    public function index(Request $req, Response $resp): Response
    {
        try {
            // picking books from database
            $db = new Database;
            $books = $db->getAll();

            $resp->getBody()->write(json_encode($books));
            // custom json response
            return $resp->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $error['err'] = $e->getMessage();
            $resp->getBody()->write(json_encode($error));
            return $resp->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function show(Request $req, Response $resp): Response
    {
        try {
            $id = $req->getAttribute('id');

            // picking a book
            $db = new Database;
            $book = $db->findById($id);

            $resp->getBody()->write(json_encode($book));
            // custom json response
            return $resp->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $error['err'] = $e->getMessage();
            $resp->getBody()->write(json_encode($error));
            return $resp->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

    }
}
