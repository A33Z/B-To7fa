<?php
class Article {
    private $id;
    private $titre;
    private $contenu;
    private $categorie;
    private $datePub;

    public function __construct($id, $titre, $contenu, $categorie, $datePub) {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->categorie = $categorie;
        $this->datePub = $datePub;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function getDatePub() {
        return $this->datePub;
    }
}
?>