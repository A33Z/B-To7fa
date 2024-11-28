<?php
class CategorieM
{
    private ?int $id_C = null;
    private ?string $libelle_c = null;
    private ?string $desc_c = null;
   

    public function __construct($libelle, $description)
    {
        $this->id_C = NULL;
        $this->libelle_c = $libelle;
        $this->desc_c = $description;
    }

    public function get_IdC()
    {
        return $this->id_C;
    }
    public function get_libelle()
    {
        return $this->libelle_c;
    }
    public function get_desc()
    {
        return $this->desc_c;
    }
    public function setLibelle_c($libelle_c)
    {
        $this->libelle_c= $libelle_c;
    }

    public function setDesc($desc_c)
    {
        $this->desc_c= $desc_c;
    }
 
}

?>