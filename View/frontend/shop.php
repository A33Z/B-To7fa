<?php
include_once 'C:\xampp\htdocs\New folder (3)\B-To7fa-main\pull\B-TO7FA\Controller\CategorieC.php';
include_once 'C:\xampp\htdocs\New folder (3)\B-To7fa-main\pull\B-TO7FA\Controller\produit_c.php'; 

$db = Config::getConnexion();
$categorie = new Categorie($db);
$categories = $categorie->getAll();

$produit = new Produit($db);

// Check if category_id is passed in the URL
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    $produits = $produit->getByCategory($categoryId);  // Get products for a specific category
} else {
    $produits = $produit->getAll();  // Get all products if no category is selected
}

$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = trim($_POST['search_query']);
    $produits = $produit->searchByName($searchQuery);
} else if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    $produits = $produit->getByCategory($categoryId);
} else {
    $produits = $produit->getAll();
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
</head>

<body>
  <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
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
          <li><a class="nav-link" href="blog.html">Blog</a></li>
          <li><a class="nav-link" href="contact.html">Contactez-nous</a></li>
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
        <input type="text" name="search_query" class="form-control" placeholder="Rechercher un produit" value="<?= htmlspecialchars($searchQuery) ?>" >
        <button type="submit" class="btn btn-primary" name="search">Rechercher</button>
      </div>
    </form>
  <div class="untree_co-section product-section before-footer-section">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-5">
          <h2 class="mb-4">Categories</h2>
          <ul class="category-list row">
            <li class="category-item col-md-6 mb-3">
              <a href="shop.php" class="category-link" data-category-id="all">Tous</a>
            </li>
            <?php while ($row = $categories->fetch(PDO::FETCH_ASSOC)) { ?>
              <li class="category-item col-md-6 mb-3">
                <a href="shop.php?category_id=<?php echo $row['ID']; ?>" class="category-link">
                  <div class="p-3 border rounded">
                    <h2><?php echo htmlspecialchars($row['Libelle']); ?></h2>
                    <p><?php echo htmlspecialchars($row['Description']); ?></p>
                  </div>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>

        <div class="col-12 mb-5">
          <h2 class="mb-4">Nos Produits</h2>
          <div class="row" id="product-list">
            <?php while ($product = $produits->fetch(PDO::FETCH_ASSOC)) { ?>
              <div class="col-12 col-md-4 col-lg-3 mb-5 product-item" data-category-id="<?php echo $product['id_c']; ?>">
                <a class="product-item" href="shop.php">
                  <img src="./images/<?php echo htmlspecialchars($product['picture']); ?>" class="img-fluid product-thumbnail" alt="Product Image">
                  <h3 class="product-title"><?php echo htmlspecialchars($product['libelle']); ?></h3>
                  <strong class="product-price"><?php echo number_format($product['price'], 2); ?> DT</strong>
                  <span class="icon-cross">
                    <img src="images/cross.svg" class="img-fluid">
                  </span>
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer-section">
    <div class="container relative">
      <div class="row">
        <div class="col-lg-8">
          <div class="subscription-form">
            <h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Abonnez-vous à notre newsletter</span></h3>
            <form action="#" class="row g-3">
              <div class="col-auto">
                <input type="text" class="form-control" placeholder="Enter your name">
              </div>
              <div class="col-auto">
                <input type="email" class="form-control" placeholder="Enter your email">
              </div>
              <div class="col-auto">
                <button class="btn btn-primary">
                  <span class="fa fa-paper-plane"></span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/tiny-slider.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>















