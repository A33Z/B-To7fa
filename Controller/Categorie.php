<?php

include_once 'Categorie.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Libelle']) && isset($_POST['Description'])) {
        $Libelle = $_POST['Libelle'];
        $Description = $_POST['Description'];

        // Create an instance of the Categorie class
        $categoryObj = new Categorie($db);

        // Call the create method to insert the new category
        if ($categoryObj->create($Libelle, $Description)) {
            echo "Category created successfully!";
        } else {
            echo "Failed to create category.";
        }
    }

}
?>