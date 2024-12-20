<?php
include_once '../../Controller/commande_c.php';
include_once '../../Model/commande_m.php';
include_once '../../Controller/produit_c.php';
include_once '../../View/config.php';

$db = config::getConnexion();
$produitController = new Produit($db);
$commandeController = new CommandeM($db);
$produits = $produitController->getAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $status = $_POST["status"];
        $ref_p = $_POST["ref_p"];
        
        if (!empty($ref_p)) { // Ensure ref_p is not empty
            if ($commandeController->addCommande($status, $ref_p)) {
                echo "Commande added successfully!";
            } else {
                echo "Error adding commande.";
            }
        } else {
            echo "Please select a product.";
        }
    }

    if (isset($_POST["delete"])) {
        $id_c = $_POST["id_c"];
        if ($commandeController->deleteCommande($id_c)) {
            echo "Commande deleted successfully!";
        } else {
            echo "Error deleting commande.";
        }
    }

    if (isset($_POST["update"])) {
        $id_c = $_POST["id_c"];
        $new_status = $_POST["new_status"];
        if ($commandeController->updateCommande($id_c, $new_status)) {
            echo "Commande updated successfully!";
        } else {
            echo "Error updating commande.";
        }
    }
}

$commandes = $commandeController->getAllCommandes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commandes</title>
    <link rel="stylesheet" href="./css2/css.css?v=1.1">
</head>
<body>
    <h1>Commandes</h1>
    <form method="POST">
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        
        <label for="ref_p">Select Product:</label>
        <select id="ref_p" name="ref_p" required>
            <option value="">-- Select Product --</option>
            <?php
            while ($row = $produits->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['reference'] . "'>" . $row['libelle'] . "</option>";
            }
            ?>
        </select>
        
        <button type="submit" name="add">Add Commande</button>
    </form>
    
    <h2>All Commandes</h2>
    <ul>
    <?php
    while ($row = $commandes->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>ID: " . $row["ID_c"] . " - Date: " . $row["date_c"] . " - Status: " . $row["status"] . " - Product: " . $row["ref_p"];
        echo " 
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id_c' value='" . $row["ID_c"] . "'>
            <button type='submit' name='delete'>Delete</button>
        </form>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id_c' value='" . $row["ID_c"] . "'>
            <input type='text' name='new_status' placeholder='New Status' required>
            <button type='submit' name='update'>Update</button>
        </form>
        </li>";
    }
    ?>
    </ul>
</body>
</html>
