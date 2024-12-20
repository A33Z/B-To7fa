<?php

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