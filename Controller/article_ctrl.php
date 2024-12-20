<?php


class ArticleController
{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM Article"; 
        $sql = $this->conn->prepare($query);
        $sql->execute();
        return $sql;
    }

    public function getArticleById($id) {
        $query = "SELECT * FROM article WHERE id = :id";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function create($titre, $contenu, $categorie, $date_pub,$picture) {
        $query = "INSERT INTO Article (titre, contenu, categorie, date_pub,picture) VALUES (:titre, :contenu, :categorie, :date_pub,:picture)";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':titre', $titre);
        $sql->bindParam(':contenu', $contenu);
        $sql->bindParam(':categorie', $categorie);
        $sql->bindParam(':date_pub', $date_pub);
        $sql->bindParam(':picture', $picture);
        return $sql->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM Article WHERE id = :id"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id', $id); 
        return $sql->execute();
    }

    public function update($titre, $contenu, $categorie, $date_pub, $id,$picture) {
        $query = "UPDATE Article SET titre = :titre, contenu = :contenu, categorie = :categorie, date_pub = :date_pub,picture = :picture WHERE id = :id";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':titre', $titre);
        $sql->bindParam(':contenu', $contenu);
        $sql->bindParam(':categorie', $categorie);
        $sql->bindParam(':date_pub', $date_pub);
        $sql->bindParam(':id', $id); 
        $sql->bindParam(':price', $picture);
        return $sql->execute();
    }
}
?>
