<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use App\models\Database;

require '../bootstrap.php';

// Instantiate app
$app = AppFactory::create();

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

$app->get('/', function (Request $req, Response $resp, $args) {
    $resp->getBody()->write('Hello World!');
});

// all books
$app->get('/books', function (Request $req, Response $resp) {
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
});

// get one book by id
$app->get('/books/{id}', function (Request $req, Response $resp) {
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
});

$app->run();
