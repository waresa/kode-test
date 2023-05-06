<?php

namespace App\Controller;

use App\Model\Post;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostController
{
    public function create(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $data['title'] = htmlspecialchars(strip_tags($data['title']));
        $data['content'] = htmlspecialchars(strip_tags($data['content']));
        $data['user_id'] = htmlspecialchars(strip_tags($data['user_id']));

        $post = new Post($data);
        $post->create();

       //return response with a success message in JSON format
       $response->getBody()->write(json_encode(['message' => 'Post created successfully']));
       return $response->withHeader('Content-Type', 'application/json');
    }

    public function getById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if (!is_numeric($id)) {
            $response->getBody()->write(json_encode(['message' => 'Invalid ID']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400); 
        }

        $postModel = new Post();
        $post = $postModel->getById($id);

        if (!$post) {
            $response->getBody()->write(json_encode(['message' => 'Post not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode($post));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getPosts(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $queryParams = filter_var_array($queryParams, FILTER_SANITIZE_NUMBER_INT);

        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        $limit = isset($queryParams['limit']) ? (int)$queryParams['limit'] : 2;

        $postModel = new Post();
        $posts = $postModel->getPosts($page, $limit);

        $response->getBody()->write(json_encode($posts));
        return $response->withHeader('Content-Type', 'application/json');
    }
}