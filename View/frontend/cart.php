<?php
include_once '../../Controller/produit_c.php';
include_once '../../Controller/add_to_cart.php';
include_once '../../View/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: shop.php");
    exit();
}

$userId = $_SESSION['user_id'];

$db = Config::getConnexion();
$cartController = new CartController($db);

$cartItems = $cartController->getUserCartItems($userId);

$groupedCartItems = [];
foreach ($cartItems as $item) {
    $productId = $item['product_id'];
    if (isset($groupedCartItems[$productId])) {
        $groupedCartItems[$productId]['quantity'] += $item['quantity'];
    } else {
        $groupedCartItems[$productId] = $item;
    }
}

$totalPrice = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $cartItemId = $_POST['remove'];
    $cartController->removeCartItem($cartItemId);
    header("Location: cart.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    // Get the cart item ID and the new quantity from the POST data
    $cartItemId = $_POST['cart_item_id'];
    $newQuantity = $_POST['quantity'];

    // Log the incoming data for debugging
    error_log("Received update request: Cart Item ID: $cartItemId, New Quantity: $newQuantity");

    // Validate the new quantity (should be a positive integer)
    if (is_numeric($newQuantity) && $newQuantity > 0) {
        // Update the cart item quantity in the database
        if ($cartController->updateCartItemQuantity($cartItemId, $newQuantity)) {
            error_log("Cart item updated successfully: Cart Item ID: $cartItemId, New Quantity: $newQuantity");
        } else {
            error_log("Failed to update cart item quantity in the database");
        }
    } else {
        error_log("Invalid quantity value: $newQuantity");
    }

    // Redirect to the cart page to reflect the changes
    header("Location: cart.php");
    exit();
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
  <link href="css/style.css" rel="stylesheet">
  <title>Your Cart</title>
</head>

<body>
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
          <li><a class="nav-link" href="about.html">A propos de nous</a></li>
          <li><a class="nav-link" href="services.html">Services</a></li>
          <li><a class="nav-link" href="blog.php">Blog</a></li>
          <li><a class="nav-link" href="commentaire.php">Contactez-nous</a></li>
        </ul>
        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li><a class="nav-link" href="profile.php"><img src="images/user.svg"></a></li>
          <li><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="hero">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <div class="intro-excerpt">
            <h1>Cart</h1>
          </div>
        </div>
        <div class="col-lg-7"></div>
      </div>
    </div>
  </div>

  <div class="untree_co-section before-footer-section">
    <div class="container">
      <div class="row mb-5">
        <form class="col-md-12" method="post">
          <div class="site-blocks-table">
            <table class="table">
              <thead>
                <tr>
                  <th class="product-thumbnail">Image</th>
                  <th class="product-name">Product</th>
                  <th class="product-price">Price</th>
                  <th class="product-quantity">Quantity</th>
                  <th class="product-total">Total</th>
                  <th class="product-remove">Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($groupedCartItems as $item) {
                    $product = $cartController->getProductById($item['product_id']);
                    $total = $product['price'] * $item['quantity'];
                    $totalPrice += $total;
                ?>
                <tr>
                    <td class="product-thumbnail">
                        <img src="./images/<?= htmlspecialchars($product['picture']) ?>" alt="Image" class="img-fluid">
                    </td>
                    <td class="product-name">
                        <h2 class="h5 text-black"><?= htmlspecialchars($product['libelle']) ?></h2>
                    </td>
                    <td>$<?= htmlspecialchars($product['price']) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="cart_item_id" value="<?= htmlspecialchars($item['id']) ?>">
                            <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" min="1" class="form-control text-center quantity-amount">
                            <button type="submit" name="update_quantity" class="btn btn-outline-black btn-sm">Update</button>
                        </form>
                    </td>
                    <td>$<?= number_format($total, 2) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="remove" value="<?= htmlspecialchars($item['id']) ?>">
                            <button type="submit" class="btn btn-black btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="row mb-5">
            <div class="col-md-6">
            <form method="POST" action="shop.php">
              <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="text-black h4" for="coupon">Coupon</label>
              <p>Enter your coupon code if you have one.</p>
            </div>
            <div class="col-md-8 mb-3 mb-md-0">
              <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
            </div>
            <div class="col-md-4">
              <button class="btn btn-black">Apply Coupon</button>
            </div>
          </div>
        </div>
        <div class="col-md-6 pl-5">
          <div class="row justify-content-end">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-12 text-right border-bottom mb-5">
                  <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <span class="text-black">Subtotal</span>
                </div>
                <div class="col-md-6 text-right">
                  <strong class="text-black">$<?= number_format($totalPrice, 2) ?></strong>
                </div>
              </div>
              <div class="row mb-5">
                <div class="col-md-6">
                  <span class="text-black">Total</span>
                </div>
                <div class="col-md-6 text-right">
                  <strong class="text-black">$<?= number_format($totalPrice, 2) ?></strong>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                <form method="POST" action="checkout.php">
                  <button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='checkout.php'">Proceed To Checkout</button>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/tiny-slider.js"></script>
  <script src="js/main.js"></script>
</body>
</html>