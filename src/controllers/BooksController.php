<?php

namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\models\Database;
use App\helpers\Helper;
use App\models\Book;

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

    public function save(Request $req, Response $resp): Response
    {
        try {
            $book = Helper::jsonToObject($req->getBody()->getContents());

            // picking a book
            $db = new Database;
            $bk = new Book();

            $bk->__set('title', $book->title);
            $bk->__set('author', $book->author);
            $bk->__set('book_description', $book->book_description);
            $id = $db->save($bk);
            // custom json response
            $resp->getBody()->write(json_encode($db->findById($id)));
            return $resp->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $error['err'] = $e->getMessage();
            $resp->getBody()->write(json_encode($error));
            return $resp->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

    }
}
