<?php

class Config {
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            try {
                
                self::$pdo = new PDO("mysql:host=localhost;dbname=achat", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                echo "Connected successfully";
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

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

    public function create($titre, $contenu, $categorie, $date_pub) {
        $query = "INSERT INTO Article (titre, contenu, categorie, date_pub) VALUES (:titre, :contenu, :categorie, :date_pub)";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':titre', $titre);
        $sql->bindParam(':contenu', $contenu);
        $sql->bindParam(':categorie', $categorie);
        $sql->bindParam(':date_pub', $date_pub);
        return $sql->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM Article WHERE id = :id"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id', $id); 
        return $sql->execute();
    }

    public function update($titre, $contenu, $categorie, $date_pub, $id) {
        $query = "UPDATE Article SET titre = :titre, contenu = :contenu, categorie = :categorie, date_pub = :date_pub WHERE id = :id";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':titre', $titre);
        $sql->bindParam(':contenu', $contenu);
        $sql->bindParam(':categorie', $categorie);
        $sql->bindParam(':date_pub', $date_pub);
        $sql->bindParam(':id', $id); 
        return $sql->execute();
    }
}
?>
