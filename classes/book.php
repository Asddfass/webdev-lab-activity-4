<?php

require_once "database.php";

class book
{
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication	 = "";

    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addBook()
    {
        $sql = "INSERT INTO book (title, author, genre, publication) VALUE (:title, :author, :genre, :publication)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication", $this->publication);

        return $query->execute();
    }

    public function viewBooks($search = "", $genre = "")
    {
        $sql = "";
        if (!empty($genre))
        {
            $sql = "SELECT * FROM book WHERE title LIKE CONCAT ('%', :search, '%') AND genre = :genre ORDER BY title ASC";
        }
        else
        {
            $sql = "SELECT * FROM book WHERE title LIKE CONCAT ('%', :search, '%') ORDER BY title ASC";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        if (!empty($genre))
        {
            $query->bindParam(":genre", $genre);
        }

        if ($query->execute())
        {
            return $query->fetchAll();
        }
        else
        {
            return null;
        }
    }
}