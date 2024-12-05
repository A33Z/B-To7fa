<?php
class ProduitM
{
    private ?int $reference = null;
    private ?string $libelle = null;
    private ?int $qte_stock = null;
    private ?string $date_c = null;
    private ?string $states = null;
    private ?int $id_c = null;
    private ?string $picture = null;
    private ?float $price = null;

    public function __construct($reference, $libelle, $qte_stock, $date_c, $states, $id_c, $picture, $price)
    {
        $this->reference = $reference;
        $this->libelle = $libelle;
        $this->qte_stock = $qte_stock;
        $this->date_c = $date_c;
        $this->states = $states;
        $this->id_c = $id_c;
        $this->picture = $picture;
        $this->price = $price;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function getQteStock()
    {
        return $this->qte_stock;
    }

    public function getDateC()
    {
        return $this->date_c;
    }

    public function getStates()
    {
        return $this->states;
    }

    public function getIdC()
    {
        return $this->id_c;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function setQteStock($qte_stock)
    {
        $this->qte_stock = $qte_stock;
    }

    public function setDateC($date_c)
    {
        $this->date_c = $date_c;
    }

    public function setStates($states)
    {
        $this->states = $states;
    }

    public function setIdC($id_c)
    {
        $this->id_c = $id_c;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}
?>
