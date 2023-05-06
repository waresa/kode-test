<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add routing middleware
$app->addRoutingMiddleware();

// Add error middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Instantiate PostController
$postController = new \App\Controller\PostController();

$app->get('/', function (Request $request, Response $response) {
    $file = __DIR__ . '/index.html';
    $response->getBody()->write(file_get_contents($file));
    return $response->withHeader('Content-Type', 'text/html');
});

//test route
$app->get('/test-json', function (Request $request, Response $response) {
    $data = [
        'status' => 'success',
        'message' => 'This is a simple JSON test route'
    ];

    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

// Add your routes here
$app->post('/api/posts', function (Request $request, Response $response) use ($postController) {
    return $postController->create($request, $response);
});

$app->get('/api/posts/{id}', function (Request $request, Response $response, array $args) use ($postController) {
    return $postController->getById($request, $response, $args);
});

$app->get('/api/posts', function (Request $request, Response $response) use ($postController) {
    return $postController->getPosts($request, $response);
});

$app->run();