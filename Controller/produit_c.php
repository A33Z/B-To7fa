<?php



class Produit {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM Produit"; 
        $sql = $this->conn->prepare($query);
        $sql->execute();
        return $sql;
    }

    public function ReferenceById($reference) {
        $query = "SELECT * FROM Produit WHERE reference = :reference";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':reference', $reference);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function create($reference, $libelle, $qte_stock, $date_c, $states, $id_c, $picture, $price) {
        $query = "INSERT INTO Produit (reference, libelle, qte_stock, date_c, states, id_c, picture, price) 
                  VALUES (:reference, :libelle, :qte_stock, :date_c, :states, :id_c, :picture, :price)";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':reference', $reference);
        $sql->bindParam(':libelle', $libelle);
        $sql->bindParam(':qte_stock', $qte_stock);
        $sql->bindParam(':date_c', $date_c);
        $sql->bindParam(':states', $states);
        $sql->bindParam(':id_c', $id_c);
        $sql->bindParam(':picture', $picture);
        $sql->bindParam(':price', $price);
        return $sql->execute();
    }

    public function delete($reference) {
        $query = "DELETE FROM Produit WHERE reference = :reference"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':reference', $reference); 
        return $sql->execute();
    }

    public function update($reference, $libelle, $qte_stock, $date_c, $states, $id_c, $picture, $price) {
        $query = "UPDATE Produit 
                  SET libelle = :libelle, qte_stock = :qte_stock, date_c = :date_c, states = :states, 
                      id_c = :id_c, picture = :picture, price = :price
                  WHERE reference = :reference";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':libelle', $libelle);
        $sql->bindParam(':qte_stock', $qte_stock);
        $sql->bindParam(':date_c', $date_c);
        $sql->bindParam(':states', $states);
        $sql->bindParam(':id_c', $id_c);
        $sql->bindParam(':picture', $picture);
        $sql->bindParam(':price', $price);
        $sql->bindParam(':reference', $reference); 
        return $sql->execute();
    }
}
?>
