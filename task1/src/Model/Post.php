<?php
namespace App\Model;

// model class for Post
class Post
{
    // properties of the Post class
    public $id;
    public $title;
    public $content;
    public $user_id;
    public $created_date;

    // constructor function for the Post class
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->content = $data['content'];
        $this->user_id = $data['user_id'];
        $this->created_date = $data['created_date'];
    }
}