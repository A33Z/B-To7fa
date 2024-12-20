<?php
class User {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $tel;
    private $adresse;
    private $sexe;
    private $dateNai;
    private $role;
    private $password;

    public function __construct($id, $nom, $prenom, $email, $tel, $adresse, $sexe, $dateNai, $role, $password = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->tel = $tel;
        $this->adresse = $adresse;
        $this->sexe = $sexe;
        $this->dateNai = $dateNai;
        $this->role = $role;
        if ($password) {
            $this->password = $password;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTel() {
        return $this->tel;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getSexe() {
        return $this->sexe;
    }

    public function getDateNai() {
        return $this->dateNai;
    }

    public function getRole() {
        return $this->role;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
?>
