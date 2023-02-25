<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use App\controllers\BooksController;

require '../bootstrap.php';

// Instantiate app
$app = AppFactory::create();

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

$app->get('/', function (Request $req, Response $resp): Response {
    $resp->getBody()->write('Hello World!');
    return $resp;
});
// all books
$app->get('/books', BooksController::class . ':index');
// get one book by id
$app->get('/books/{id}', BooksController::class . ':show');
// save a book
$app->post('/books', BooksController::class . ':save');

$app->run();
