<?php
require_once 'C:\xampp\htdocs\New folder (3)\B-To7fa-main\pull\B-TO7FA\Model\produitM.php';
require_once 'C:\xampp\htdocs\New folder (3)\B-To7fa-main\pull\B-TO7FA\Controller\produit_c.php';

$db = Config::getConnexion();
$produit = new Produit($db);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $reference = $_POST['reference'] ?? '';
    $libelle = $_POST['libelle'] ?? '';
    $qte_stock = $_POST['qte_stock'] ?? 0;
    $date_c = $_POST['date_c'] ?? '';
    $states = $_POST['states'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $picture = $_FILES['picture']['name'] ?? '';

    if ($picture) {
        // Ensure the 'uploads' directory exists
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
        }

        $targetFile = $targetDir . basename($picture);
        $uploadSuccess = move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile);

        if (!$uploadSuccess) {
            $message = "Error uploading the picture. Please try again.";
        } else {
            $states = $qte_stock == 0 ? 'Hors Stock' : 'En Stock';

            if ($produit->create($reference, $libelle, $qte_stock, $date_c, $states, $category, $picture, $price)) {
                $message = "Product successfully added!";
            } else {
                $message = "Error adding the product.";
            }
        }
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

if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];
    $productToUpdate = $produit->ReferenceById($reference);
    if ($productToUpdate) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
            $libelle = $_POST['libelle'] ?? '';
            $qte_stock = $_POST['qte_stock'] ?? 0;
            $date_c = $_POST['date_c'] ?? '';
            $states = $_POST['states'] ?? '';
            $category = $_POST['category'] ?? '';
            $price = $_POST['price'] ?? 0;
            $picture = $_FILES['picture']['name'] ?? $productToUpdate['picture'];

            if ($picture !== $productToUpdate['picture']) {
                $targetDir = "uploads/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
                }
                $targetFile = $targetDir . basename($picture);
                $uploadSuccess = move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile);

                if (!$uploadSuccess) {
                    $message = "Error uploading the picture. Please try again.";
                }
            }

            $states = $qte_stock == 0 ? 'Hors Stock' : 'En Stock';

            if ($produit->update($reference, $libelle, $qte_stock, $date_c, $states, $category, $picture, $price)) {
                $message = "Product successfully updated!";
            } else {
                $message = "Error updating the product.";
            }
        }
    } else {
        $message = "Product not found!";
    }
}

$products = $produit->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="./css/style.css?v=1.1">
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

    <input type="hidden" id="states" name="states" value="<?= htmlspecialchars($productToUpdate['states'] ?? '') ?>">

    <label for="category">Category:</label>
    <select id="category" name="category" required>
        <option value="1" <?= isset($productToUpdate['id_c']) && $productToUpdate['id_c'] == 1 ? 'selected' : '' ?>>Shoes</option>
        <option value="2" <?= isset($productToUpdate['id_c']) && $productToUpdate['id_c'] == 2 ? 'selected' : '' ?>>Shirts</option>
        <option value="3" <?= isset($productToUpdate['id_c']) && $productToUpdate['id_c'] == 3 ? 'selected' : '' ?>>Earrings</option>
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
            <th>Quantity in Stock</th>
            <th>Creation Date</th>
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
                <td><img src="./uploads/<?= htmlspecialchars($product['picture']) ?>" width="50" height="50" alt="Product Image"></td>
                <td>
                    <button><a href="?reference=<?= $product['reference'] ?>" style="color: white;">Update</a></button>
                    <button><a href="?delete=<?= $product['reference'] ?>" style="color: white;">Delete</a></button>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
