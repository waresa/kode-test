<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add routing middleware
$app->addRoutingMiddleware();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Instantiate PostController
$postController = new \App\Controller\PostController();

$app->get('/', function (Request $request, Response $response) {
    $file = __DIR__ . '/index.html';
    $response->getBody()->write(file_get_contents($file));
    return $response->withHeader('Content-Type', 'text/html');
});

// Add your routes here
$app->post('/api/posts', function (Request $request, Response $response) use ($postController) {
    return $postController->create($request, $response);
});

$app->get('/api/posts/{id}', function (Request $request, Response $response, array $args) use ($postController) {
    return $postController->getById($request, $response, $args);
});

$app->get('/api/posts', function (Request $request, Response $response, array $args) use ($postController) {
    return $postController->getPosts($request, $response, $args);
});

$app->run();