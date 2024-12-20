<?php
include_once '../../Controller/CategorieC.php';
include_once '../../Controller/produit_c.php'; 
include_once '../../Controller/add_to_cart.php';
include_once '../../View/config.php';
session_start();

$db = Config::getConnexion();
$categorie = new Categorie($db);
$categories = $categorie->getAll();

$produit = new Produit($db);
$cartController = new CartController($db);

// Initialize notification message
$notificationMessage = '';

if (isset($_POST['add_to_cart'])) {
  $productId = $_POST['product_id'];
  $quantity = $_POST['quantity']; // Get the requested quantity
  $product = $produit->getByReference($productId); // Fetch the product details

  if ($product) {
      $availableStock = $product['qte_stock']; // Available stock in the product table
      if ($quantity <= $availableStock && $quantity > 0) {
          if (isset($_SESSION['user_id'])) {
              $userId = $_SESSION['user_id'];
              $cartController->create($userId, $productId, $quantity); // Add to cart
              
              // Reduce the stock in the database
              $newStock = $availableStock - $quantity;
              $produit->updateStock($productId, $newStock);
              
              // If stock reaches 0, update product status to 'HORS STOCK'
              if ($newStock == 0) {
                  $produit->updateStatus($productId, 'HORS STOCK');
              }

              $_SESSION['cart_notification'] = "Produit ajouté au panier!";
          } else {
              echo "User not logged in.";
          }
      } else {
          $_SESSION['cart_notification'] = "Quantité invalide ou stock insuffisant!";
      }
  }
}

if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    if ($categoryId == 'all') {
        $produits = $produit->getAll(); // Fetch all products when "Tous" is clicked
    } else {
        $produits = $produit->getByCategory($categoryId);  
    }
} else {
    $produits = $produit->getAll(); // Default to all products if no category is selected  
}

$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = trim($_POST['search_query']);
    $produits = $produit->searchByName($searchQuery);
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="css/tiny-slider.css" rel="stylesheet">
  <link href="css/style.css?v=1.1" rel="stylesheet">
  <title>Boutique </title>

  <style>
    /* Notification styles */
    .notification {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #28a745;
        color: white;
        padding: 10px;
        border-radius: 5px;
        display: none;
        z-index: 1000;
    }
    .sidebar {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.sidebar h4 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 15px;
    text-align: center;  /* Center the header */
}
.cat{
  font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 15px;
    text-align: center;  /* Center the header */
}
.sidebar h4:hover {
    font-size: 1.5rem;
    font-weight: bold;
    color: #f8f9fa;
    margin-bottom: 15px;
    text-align: center;  /* Center the header */
}

.sidebar .list-group {
    padding: 0;
    list-style: none; /* Remove default list styling */
    text-align: center; /* Center the category items */
}

.sidebar .list-group-item {
    background-color: transparent;
    border: none;
    padding: 10px;
    font-size: 1rem;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar .list-group-item:hover {
    background-color: #6b210a;
    color: #fff;
    transform: scale(1.05);
}

.sidebar .list-group-item a {
    color: inherit;
    text-decoration: none;
    display: block;
}

.sidebar .list-group-item.active {
    background-color: #6b210a;
    color: white;
    font-weight: bold;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 767px) {
    .sidebar {
        margin-top: 10px;
        padding: 15px;
    }

    .sidebar h4 {
        font-size: 1.25rem;
    }

    .sidebar .list-group-item {
        font-size: 0.9rem;
    }
}
  </style>
</head>

<body>
  <!-- Notification -->
  <div id="notification" class="notification">
      <?php if (isset($_SESSION['cart_notification'])): ?>
          <?php echo $_SESSION['cart_notification']; ?>
          <?php unset($_SESSION['cart_notification']); ?>
      <?php endif; ?>
  </div>

  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
    <div class="container">
      <a class="navbar-brand" href="index.html">B-TO7FA<span>.</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsFurni">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Accueil</a>
          </li>
          <li class="active"><a class="nav-link" href="shop.php">Boutique</a></li>
          <li><a class="nav-link" href="about.html">à propos de nous</a></li>
          <li><a class="nav-link" href="services.html">Services</a></li>
          <li><a class="nav-link" href="blog.php">Blog</a></li>
          <li><a class="nav-link" href="commentaire.php">Contactez-nous</a></li>
        </ul>
        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li><a class="nav-link" href="#"><img src="images/user.svg"></a></li>
          <li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <div class="intro-excerpt">
            <h1>Boutique</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" class="mb-4" action="shop.php">
    <div class="input-group">
      <input type="text" name="search_query" class="form-control" placeholder="Rechercher un produit" value="<?= htmlspecialchars($searchQuery) ?>">
      <button type="submit" class="btn btn-primary" name="search">Rechercher</button>
    </div>
  </form>

  
    <h4 class="cat">Catégories</h4>
    <div class="sidebar mb-4">
    <ul class="list-group">
      <!-- Add "Tous" category link -->
      <li class="list-group-item">
      <h4> <a href="shop.php?category_id=all">
          Tous
        </a></h4>
      </li>
      <?php foreach ($categories as $cat) { ?>
        <li class="list-group-item">
          <h4><a href="shop.php?category_id=<?= $cat['ID']; ?>">
            <?= htmlspecialchars($cat['Libelle']); ?>
          </a></h4>
        </li>
      <?php } ?>
    </ul>
  </div>

  <div class="untree_co-section product-section before-footer-section">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-5">
          <h2 class="mb-4">Nos Produits</h2>
          <div class="row" id="product-list">
            <?php while ($product = $produits->fetch(PDO::FETCH_ASSOC)) { ?>
              <div class="col-12 col-md-4 col-lg-3 mb-5 product-item">
                <form method="POST" action="shop.php">
                  <input type="hidden" name="product_id" value="<?= $product['reference']; ?>">
                  <a href="#">
                    <img src="./images/<?= htmlspecialchars($product['picture']); ?>" class="img-fluid product-thumbnail" alt="Product Image">
                    <h3 class="product-title"><?= htmlspecialchars($product['libelle']); ?></h3>
                    <strong class="product-price"><?= number_format($product['price'], 2); ?> DT</strong>
                  </a>
                  <!-- Quantity input field -->
                  <div class="form-group">
                    <label for="quantity">Quantité</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" value="1" min="1" max="<?= $product['qte_stock']; ?>">
                    <small class="form-text text-muted">Max: <?= $product['qte_stock']; ?> <?= $product['states']; ?></small>
                  </div>
                  <button type="submit" name="add_to_cart" class="btn btn-primary mt-2">Ajouter au panier</button>
                </form>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/tiny-slider.js"></script>
  <script src="js/custom.js"></script>

  <script>
    // Show the notification if it's set
    window.onload = function() {
      var notification = document.getElementById('notification');
      if (notification.innerText !== '') {
        notification.style.display = 'block';
        setTimeout(function() {
          notification.style.display = 'none';
        }, 3000); // Hide after 3 seconds
      }
    };
  </script>
</body>
</html>
