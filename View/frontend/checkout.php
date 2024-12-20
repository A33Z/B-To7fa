<?php
include_once '../../Controller/produit_c.php';
include_once '../../Controller/add_to_cart.php';
include_once '../../View/config.php';
include_once '../../Controller/ordersC.php';
include_once '../../Model/ordersM.php';
session_start();

$userId = $_SESSION['user_id'] ?? null;
$db = Config::getConnexion();
$cartController = new CartController($db);
$orderController = new OrderController($db);

// Get grouped cart items
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

// Calculate total price
$totalPrice = 0;
foreach ($groupedCartItems as $item) {
    $product = $cartController->getProductById($item['product_id']);
    $totalPrice += $product['price'] * $item['quantity'];
}

// Process the order if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    $delivery = isset($_POST['delivery']) ? 1 : 0;

    if (
        $userId && $first_name && $last_name && $email && $phone && 
        $address && $country && $state && $postal_code
    ) {
        try {
            $order_id = $orderController->create(
                $userId, $first_name, $last_name, $email, $phone, 
                $address, $country, $state, $postal_code, $delivery, $totalPrice
            );

            if ($order_id) {
            } else {
                
            }
        } catch (Exception $e) {
            
        }
    } else {
        
    }

    if (isset($_POST['thankyou'])) {
      echo "Thank you button clicked.<br>";  // Debugging line
      if ($cartController->clearUserCart($userId)) {
        header("Location: thankyou.php");
      } else {
          
      }
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="css/tiny-slider.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Checkout - OnlyTo7fa</title>
</head>
<body>
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.html">OnlyTo7fa</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsFurni">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li><a class="nav-link" href="shop.php">Shop</a></li>
          <li><a class="nav-link" href="about.html">About us</a></li>
          <li><a class="nav-link" href="services.html">Services</a></li>
          <li><a class="nav-link" href="blog.php">Blog</a></li>
          <li><a class="nav-link" href="commentaire.php">Contact us</a></li>
        </ul>
        <ul class="navbar-nav ms-5">
            <li><a class="nav-link" href="profile.php"><img src="images/user.svg"></a></li>
						<li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>
						<li><a class="nav-link" href="login.php">Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero">
    <div class="container">
      <h1>Checkout</h1>
    </div>
  </div>

  <div class="container">
    <form action="checkout.php" method="POST">
      <div class="row">
        <div class="col-md-6">
          <h2>Billing Details</h2>
          <div class="mb-3">
            <label for="first_name">First Name *</label>
            <input type="text" id="first_name" name="first_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="last_name">Last Name *</label>
            <input type="text" id="last_name" name="last_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="phone">Phone *</label>
            <input type="text" id="phone" name="phone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="address">Address *</label>
            <input type="text" id="address" name="address" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="country">Country *</label>
            <input type="text" id="country" name="country" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="state">State *</label>
            <input type="text" id="state" name="state" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="postal_code">Postal Code *</label>
            <input type="text" id="postal_code" name="postal_code" class="form-control" required>
          </div>
          <div class="form-check">
            <input type="checkbox" id="delivery" name="delivery" class="form-check-input">
            <label for="delivery" class="form-check-label">Include Delivery</label>
          </div>
        </div>
        <div class="col-md-6">
          <h2>Your Order</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($groupedCartItems as $item) {
                $product = $cartController->getProductById($item['product_id']); ?>
                <tr>
                  <td><?= htmlspecialchars($product['libelle']) ?> (x<?= $item['quantity'] ?>)</td>
                  <td>$<?= number_format($product['price'] * $item['quantity'], 2) ?></td>
                </tr>
              <?php } ?>
              <tr>
                <td><strong>Total</strong></td>
                <td><strong>$<?= number_format($totalPrice, 2) ?></strong></td>
              </tr>
            </tbody>
          </table>
          
        </div>
      </div>
    </form>
    <form method="POST" action="checkout.php">
          <button type="submit" class="btn btn-primary" name="thankyou">Place Order</button>
          </form>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
