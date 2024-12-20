<?php
class Commentaire {
    private $id_co;
    private $name;
    private $last_name;
    private $email;
    private $message;
    private $articleId;

    public function __construct($id_co, $name, $last_name, $email, $message, $articleId) {
        $this->id_co = $id_co;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->message = $message;
        $this->articleId = $articleId;
    }

    public function getIdCo() {
        return $this->id_co;
    }

    public function getName() {
        return $this->name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getArticleId() {
        return $this->articleId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setArticleId($articleId) {
        $this->articleId = $articleId;
    }
}
?>
