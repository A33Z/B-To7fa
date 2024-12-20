<?php
session_start();
include_once '../../Controller/userC.php';
include_once '../../View/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = Config::getConnexion();
$userController = new UserController($db);

$userId = $_SESSION['user_id'];
$user = $userController->getById($userId);

include_once '../../Controller/userC.php';
include_once '../../View/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $data = [
        'nom' => htmlspecialchars($_POST['nom']),
        'prenom' => htmlspecialchars($_POST['prenom']),
        'email' => htmlspecialchars($_POST['email']),
        'tel' => htmlspecialchars($_POST['tel']),
        'adresse' => htmlspecialchars($_POST['adresse']),
        'sexe' => htmlspecialchars($_POST['sexe']),
        'date_nai' => htmlspecialchars($_POST['date_nai'])
    ];

    $userController->updateUser($userId, $data);
    $_SESSION['cart_notification'] = "Profil mis à jour avec succès!";
    header("Location: profile.php");
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
  <title>Profil de l'utilisateur</title>
  <style>
    .profile-container {
      margin: 50px auto;
      max-width: 800px;
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      font-family: 'Arial', sans-serif;
    }
    .profile-container h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 2em;
      color: #333;
    }
    .profile-item {
      margin-bottom: 20px;
    }
    .profile-item label {
      font-weight: bold;
      color: #555;
    }
    .profile-item p {
      padding: 10px;
      background: #f9f9f9;
      border-radius: 5px;
      color: #333;
    }
  </style>
</head>
<body>
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
          <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
          <li class="active"><a class="nav-link" href="shop.php">Boutique</a></li>
          <li><a class="nav-link" href="about.html">A propos de nous</a></li>
          <li><a class="nav-link" href="services.html">Services</a></li>
          <li><a class="nav-link" href="blog.php">Blog</a></li>
          <li><a class="nav-link" href="commentaire.php">Contactez-nous</a></li>
        </ul>
        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li><a class="nav-link" href="profile.php"><img src="images/user.svg"></a></li>
          <li><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
          <li><a class="nav-link" href="login.php">Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="profile-container">
      <h2>Profil de <?= htmlspecialchars($user['nom']) ?> <?= htmlspecialchars($user['prenom']) ?></h2>
      <div class="profile-item"><label>Nom :</label><p><?= htmlspecialchars($user['nom']) ?></p></div>
      <div class="profile-item"><label>Prénom :</label><p><?= htmlspecialchars($user['prenom']) ?></p></div>
      <div class="profile-item"><label>Email :</label><p><?= htmlspecialchars($user['email']) ?></p></div>
      <div class="profile-item"><label>Téléphone :</label><p><?= htmlspecialchars($user['tel']) ?></p></div>
      <div class="profile-item"><label>Adresse :</label><p><?= htmlspecialchars($user['adresse']) ?></p></div>
      <div class="profile-item"><label>Sexe :</label><p><?= htmlspecialchars($user['sexe']) ?></p></div>
      <div class="profile-item"><label>Date de naissance :</label><p><?= htmlspecialchars($user['date_nai']) ?></p></div>
    </div>

    <div class="profile-container">
      <h2>Modifier le profil</h2>
      <form action="update_profile.php" method="POST">
        <div class="profile-item"><label>Nom :</label><input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required></div>
        <div class="profile-item"><label>Prénom :</label><input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required></div>
        <div class="profile-item"><label>Email :</label><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></div>
        <div class="profile-item"><label>Téléphone :</label><input type="tel" name="tel" value="<?= htmlspecialchars($user['tel']) ?>" required></div>
        <div class="profile-item"><label>Adresse :</label><input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>" required></div>
        <div class="profile-item"><label>Sexe :</label><select name="sexe" required><option value="Homme" <?= $user['sexe'] == 'Homme' ? 'selected' : '' ?>>Homme</option><option value="Femme" <?= $user['sexe'] == 'Femme' ? 'selected' : '' ?>>Femme</option></select></div>
        <div class="profile-item"><label>Date de naissance :</label><input type="date" name="date_nai" value="<?= htmlspecialchars($user['date_nai']) ?>" required></div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </form>
    </div>
  </div>
</body>
</html>
