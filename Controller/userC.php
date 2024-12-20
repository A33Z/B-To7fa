<?php


include_once '../../Model/userM.php';


class UserController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }



    public function getAll() {
        $query = "SELECT * FROM user";
        $sql = $this->conn->prepare($query);
        $sql->execute();
        return $sql;
    }

    public function getById($id) {
        $query = "SELECT * FROM user WHERE id = :id";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data) {
        $sql = "UPDATE user SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    email = :email, 
                    tel = :tel, 
                    adresse = :adresse, 
                    sexe = :sexe, 
                    date_nai = :date_nai 
                WHERE id = :id";
    
        $query = $this->conn->prepare($sql);
        $query->execute(array_merge($data, ['id' => $id]));
    }


    public function create($nom, $prenom, $email, $tel, $adresse, $sexe, $dateNai, $role, $password) {
        $query = "INSERT INTO user (nom, prenom, email, tel, adresse, sexe, date_nai, role, password) 
                  VALUES (:nom, :prenom, :email, :tel, :adresse, :sexe, :date_nai, :role, :password)";
        $sql = $this->conn->prepare($query);
    
        // Hash the password before binding
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $sql->bindParam(':nom', $nom);
        $sql->bindParam(':prenom', $prenom);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':tel', $tel);
        $sql->bindParam(':adresse', $adresse);
        $sql->bindParam(':sexe', $sexe);
        $sql->bindParam(':date_nai', $dateNai);
        $sql->bindParam(':role', $role);
        $sql->bindParam(':password', $hashedPassword);
    
        return $sql->execute();
    }

    // Login user
    public function login($email, $password) {
        $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':email', $email);
        $sql->execute();
        $user = $sql->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Return an instance of the User class
            return new User(
                $user['id'], 
                $user['nom'], 
                $user['prenom'], 
                $user['email'], 
                $user['tel'], 
                $user['adresse'], 
                $user['sexe'], 
                $user['date_nai'], 
                $user['role'], 
                $user['password']
            );
        }
        return false;
    }
}
?>
