<?php

namespace App\Model;

use App\Util\Database;

class Post
{
    public $title;
    public $content;
    public $user_id;

    private $connection;

    // Constructor for initializing the Post object and database connection
    public function __construct($data = null)
    {
        $db = new Database();
        $this->connection = $db->getConnection();

        if ($data) {
            $this->title = $data['title'];
            $this->content = $data['content'];
            $this->user_id = $data['user_id'];
        }
    }

    // Create a new post in the database
    public function create()
    {
        $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $this->title);
        $stmt->bindValue(2, $this->content);
        $stmt->bindValue(3, $this->user_id);
        $stmt->execute();
    }

    // Get a post by its ID from the database
    public function getById($id)
    {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Get posts with pagination from the database
    public function getPosts($page, $limit)
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM posts LIMIT ? OFFSET ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}