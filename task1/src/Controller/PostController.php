<?php
namespace App\Controller;

use App\Model\Post;
use App\Util\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostController
{
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    // Create a post
    public function create(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        //sanitize data with htmlspecialchars to prevent XSS attacks
        $data['title'] = htmlspecialchars(strip_tags($data['title']));
        $data['content'] = htmlspecialchars(strip_tags($data['content']));
        $data['user_id'] = htmlspecialchars(strip_tags($data['user_id']));

        //insert data into database using prepared statements
        $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $data['title']);
        $stmt->bindValue(2, $data['content']);
        $stmt->bindValue(3, $data['user_id']);
        $stmt->execute();

        //return response with a success message in JSON format
        $response->getBody()->write(json_encode(['message' => 'Post created successfully']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Fetch a post by ID
    public function getById(Request $request, Response $response, array $args): Response
    {

        //store the id from the request in a variable
        $id = $args['id'];

        //santize the id only allowing numbers
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        //fetch the post from the database using prepared statements
        $sql = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $post = $stmt->fetch(\PDO::FETCH_ASSOC);

        //if id is not a number return invalid id message
        if (!is_numeric($id)) {
            $response->getBody()->write(json_encode(['message' => 'Invalid ID']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        //if no post is found return post not found message
        if (!$post) {
            $response->getBody()->write(json_encode(['message' => 'Post not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        //return the post in JSON format
        $response->getBody()->write(json_encode($post));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Fetch multiple posts with pagination
    public function getPosts(Request $request, Response $response): Response
    {

        //get the page and limit query parameters from the request
        $queryParams = $request->getQueryParams();

        //sanitize the query parameters only allowing numbers
        $queryParams = filter_var_array($queryParams, FILTER_SANITIZE_NUMBER_INT);


        //set default values for page and limit if not set in the request
        $page = isset($queryParams['page']) ? (int) $queryParams['page'] : 1;
        $limit = isset($queryParams['limit']) ? (int) $queryParams['limit'] : 2;


        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM posts LIMIT ? OFFSET ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($posts));
        return $response->withHeader('Content-Type', 'application/json');
    }
}