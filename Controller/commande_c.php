<?php

class DatabaseConfig {
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO("mysql:host=localhost;dbname=achat", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;  
    }
}

class CommandeC {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addCommande($date_c, $status, $ref_p) {
        $sql = "INSERT INTO commande (date_c, status, ref_p) VALUES ('$date_c', '$status', '$ref_p')";
        return $this->conn->query($sql);
    }

    public function getAllCommandes() {
        $sql = "SELECT * FROM commande";
        return $this->conn->query($sql);
    }

    public function deleteCommande($id_c) {
        $sql = "DELETE FROM commande WHERE ID_c = $id_c";
        return $this->conn->query($sql);
    }

    public function updateCommande($id_c, $new_status) {
        $sql = "UPDATE commande SET status = '$new_status' WHERE ID_c = $id_c";
        return $this->conn->query($sql);
    }
}

?>