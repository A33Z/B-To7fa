<?php

include_once 'article_ctrl.php';

class CommentaireController
{
    private $conn;

    // Constructor to initialize the connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create comment
    public function create($name, $last_name, $email, $message, $article_id) {
        $query = "INSERT INTO commentaire (name, last_name, email, message, id_a) 
                  VALUES (:name, :last_name, :email, :message, :id_a)";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':last_name', $last_name);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':message', $message);
        $sql->bindParam(':id_a', $article_id);
        return $sql->execute();
    }

    // Get all comments for a specific article
    public function getAll($article_id) {
        $query = "SELECT * FROM commentaire WHERE id_a = :id_a"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id_a', $article_id);
        $sql->execute();
        return $sql;
    }

    // Update comment
    public function update($id_co, $name, $last_name, $email, $message) {
        $query = "UPDATE commentaire SET name = :name, last_name = :last_name, email = :email, message = :message 
                  WHERE id_co = :id_co";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id_co', $id_co);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':last_name', $last_name);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':message', $message);
        return $sql->execute();
    }

    // Delete comment
    public function delete($id_co) {
        $query = "DELETE FROM commentaire WHERE id_co = :id_co"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id_co', $id_co); 
        return $sql->execute();
    }
}
?>
