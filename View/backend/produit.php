<?php
include_once '../../Model/produitM.php';
include_once '../../Controller/produit_c.php';
include_once '../../View/config.php';
include_once '../../Controller/CategorieC.php';

$db = Config::getConnexion();
$produit = new Produit($db);
$categorie = new Categorie($db);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $reference = $_POST['reference'] ?? '';
    $libelle = $_POST['libelle'] ?? '';
    $qte_stock = $_POST['qte_stock'] ?? 0;
    $date_c = $_POST['date_c'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $picture = $_FILES['picture']['name'] ?? '';

    if ($picture) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($picture);
        move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile);
    }

    $states = $qte_stock == 0 ? 'Hors Stock' : 'En Stock';

    if ($produit->create($reference, $libelle, $qte_stock, $date_c, $states, $category, $picture, $price)) {
        $message = "Product successfully added!";
    } else {
        $message = "Error adding the product.";
    }
}

if (isset($_GET['delete'])) {
    $reference = $_GET['delete'];
    if ($produit->delete($reference)) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting the product.";
    }
}

$productToUpdate = null;
if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];
    $productToUpdate = $produit->getByReference($reference);

    if ($productToUpdate && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
        $libelle = $_POST['libelle'] ?? '';
        $qte_stock = $_POST['qte_stock'] ?? 0;
        $date_c = $_POST['date_c'] ?? '';
        $category = $_POST['category'] ?? '';
        $price = $_POST['price'] ?? 0;
        $picture = $_FILES['picture']['name'] ?? $productToUpdate['picture'];

        if (!empty($_FILES['picture']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . basename($picture);
            move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile);
        }

        $states = $qte_stock == 0 ? 'Hors Stock' : 'En Stock';

        if ($produit->update($reference, $libelle, $qte_stock, $date_c, $states, $category, $picture, $price)) {
            $message = "Product successfully updated!";
            header("Location: produit.php");
            exit;
        } else {
            $message = "Error updating the product.";
        }
    }
}

if (isset($_POST['update_quantity'])) {
    $reference = $_POST['update_quantity'];
    $quantity_increase = $_POST['quantity_increase'] ?? 0;

    $product = $produit->getByReference($reference);
    if ($product) {
        $new_quantity = $product['qte_stock'] + $quantity_increase;
        $new_state = $new_quantity == 0 ? 'Hors Stock' : 'En Stock';

        if ($produit->update($reference, $product['libelle'], $new_quantity, $product['date_c'], $new_state, $product['id_c'], $product['picture'], $product['price'])) {
            $message = "Quantity successfully updated!";
        } else {
            $message = "Error updating the quantity.";
        }
    }
}

$products = $produit->getAll();
$categories = $categorie->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="./css/style.css?v=1.1">
    <style>
        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .small-button {
            font-size: 12px;
            padding: 5px 10px;
            max-width: 100px;
            text-align: center;
        }

        .quantity-input {
            width: 60px;
            font-size: 14px;
            padding: 5px;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>
<body>

<h2>Add Product</h2>
<div class="message"><?= htmlspecialchars($message) ?></div>

<form method="POST" enctype="multipart/form-data">
    <label for="reference">Reference:</label>
    <input type="text" id="reference" name="reference" value="<?= htmlspecialchars($productToUpdate['reference'] ?? '') ?>" required>

    <label for="libelle">Libelle:</label>
    <input type="text" id="libelle" name="libelle" value="<?= htmlspecialchars($productToUpdate['libelle'] ?? '') ?>" required>

    <label for="qte_stock">Quantity in Stock:</label>
    <input type="number" id="qte_stock" name="qte_stock" value="<?= htmlspecialchars($productToUpdate['qte_stock'] ?? '') ?>" required>

    <label for="date_c">Creation Date:</label>
    <input type="date" id="date_c" name="date_c" value="<?= htmlspecialchars($productToUpdate['date_c'] ?? '') ?>" required>

    <label for="price">Price:</label>
    <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($productToUpdate['price'] ?? '') ?>" required>

    <label for="category">Category:</label>
    <select id="category" name="category" required>
        <?php while ($row = $categories->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?= htmlspecialchars($row['ID']) ?>" <?= isset($productToUpdate['id_c']) && $productToUpdate['id_c'] == htmlspecialchars($row['ID']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['Libelle']) ?>
            </option>
        <?php } ?>
    </select>

    <label for="picture">Picture:</label>
    <input type="file" id="picture" name="picture">
    <?php if (!empty($productToUpdate['picture'])): ?>
        <img src="uploads/<?= htmlspecialchars($productToUpdate['picture']) ?>" width="50" height="50" alt="Product Image">
    <?php endif; ?>
    <button type="submit" name="add_product">Add Product</button>
    <button type="submit" name="update_product">Update Product</button>
</form>

<h2>Product List</h2>

<table>
    <thead>
        <tr>
            <th>Reference</th>
            <th>Libelle</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Price</th>
            <th>States</th>
            <th>Category</th>
            <th>Picture</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($product = $products->fetch()): ?>
        <tr>
            <td><?= htmlspecialchars($product['reference']) ?></td>
            <td><?= htmlspecialchars($product['libelle']) ?></td>
            <td><?= htmlspecialchars($product['qte_stock']) ?></td>
            <td><?= htmlspecialchars($product['date_c']) ?></td>
            <td><?= htmlspecialchars($product['price']) ?></td>
            <td><?= htmlspecialchars($product['states']) ?></td>
            <td><?= htmlspecialchars($product['id_c']) ?></td>
            <td><img src="uploads/<?= htmlspecialchars($product['picture']) ?>" width="50" height="50" alt="Product Image"></td>
            <td>
                <div class="action-buttons">
                    <button><a href="?reference=<?= $product['reference'] ?>" style="color: white;">Update</a></button>
                    <button><a href="?delete=<?= $product['reference'] ?>" style="color: white;">Delete</a></button>
                    <form method="POST" style="display:inline;">
                        <input type="number" name="quantity_increase" min="1" value="1" required class="quantity-input">
                        <button type="submit" name="update_quantity" value="<?= $product['reference'] ?>" class="small-button">Increase Quantity</button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
