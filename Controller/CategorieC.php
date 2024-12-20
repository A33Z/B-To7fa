<?php


class Categorie {
    private $conn;
    
    
    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function getAll() {
        $query = "SELECT * FROM Categorie"; 
        $sql = $this->conn->prepare($query);
        $sql->execute();
        return $sql;
    }

    
    public function create($Libelle, $Description) {
        $query = "INSERT INTO Categorie (Libelle, Description) VALUES (:Libelle, :Description)";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':Libelle', $Libelle);
        $sql->bindParam(':Description', $Description);
        return $sql->execute();
    }

    
    public function delete($id) {
        $query = "DELETE FROM Categorie WHERE ID = :id"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id', $id); 
        return $sql->execute();
    }

    
    public function update($id, $Libelle, $Description) {
        $query = "UPDATE Categorie SET Libelle = :Libelle, Description = :Description WHERE ID = :id";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':Libelle', $Libelle);
        $sql->bindParam(':Description', $Description);
        $sql->bindParam(':id', $id); 
        return $sql->execute();
    }
}
