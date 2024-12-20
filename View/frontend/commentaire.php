<?php
include_once '../../Controller/article_ctrl.php';
include_once '../../Controller/commentaireC.php';
include_once '../../Model/commentaireM.php';
include_once '../../View/config.php';

// Initialize form submission message
$submission_message = '';
$db = Config::getConnexion();
// Fetch all articles for the select dropdown
$articleCtrl = new ArticleController($db);
$articles = $articleCtrl->getAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $fname = htmlspecialchars(trim($_POST['fname']));
    $lname = htmlspecialchars(trim($_POST['lname']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Use isset to check if 'article_id' is set in the POST request
    $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : ''; 

    // Validate the email and other inputs
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($fname) && !empty($lname) && !empty($message) && !empty($article_id)) {
        // Create a new CommentaireController instance
        $commentaireCtrl = new CommentaireController($db);
        
        // Insert the comment into the database
        $commentaireCtrl->create($fname, $lname, $email, $message, $article_id);
        
        // Send success message
        $submission_message = "Merci pour votre message, $fname. Nous reviendrons vers vous bientôt!";
    } else {
        $submission_message = 'Veuillez remplir tous les champs correctement.';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="OnlyTo7fa">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="Site OnlyTo7fa pour la vente d'objets culturels et antiques." />
  <meta name="keywords" content="bootstrap, mobilier, antiques, OnlyTo7fa" />

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link href="css/tiny-slider.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
</head>
<body>
<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="OnlyTo7fa navigation bar">
    <div class="container">
        <a class="navbar-brand" href="index.html">OnlyTo7fa<span>.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsOnlyTo7fa" aria-controls="navbarsOnlyTo7fa" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsOnlyTo7fa">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Accueil</a>
                </li>
                <li><a class="nav-link" href="shop.php">Boutique</a></li>
                <li><a class="nav-link" href="about.html">À propos</a></li>
                <li><a class="nav-link" href="services.html">Services</a></li>
                <li><a class="nav-link" href="blog.php">Blog</a></li>
                <li class="active"><a class="nav-link" href="commentaire.php">Contactez-nous</a></li>
            </ul>
            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li><a class="nav-link" href="#"><img src="images/user.svg"></a></li>
                <li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Start Comment Form -->
<div class="untree_co-section">
    <div class="container">
        <div class="block">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8 pb-4">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-black" for="fname">Prénom</label>
                                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo isset($fname) ? $fname : ''; ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-black" for="lname">Nom de famille</label>
                                    <input type="text" class="form-control" id="lname" name="lname" value="<?php echo isset($lname) ? $lname : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-black" for="email">Adresse e-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-black" for="message">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="6"><?php echo isset($message) ? $message : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-black" for="article_id">Sélectionner un article</label>
                                    <select class="form-control" id="article_id" name="article_id">
                                        <option value="">Sélectionner un article</option>
                                        <?php foreach ($articles as $article): ?>
                                            <option value="<?php echo $article['id']; ?>" <?php echo isset($article_id) && $article_id == $article['id'] ? 'selected' : ''; ?>>
                                                <?php echo $article['titre']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Envoyer le message</button>
                        </div>
                    </form>

                    <!-- Displaying Submission Message -->
                    <?php if ($submission_message) { ?>
                        <div class="alert alert-info mt-3"><?php echo $submission_message; ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Comment Form -->

<!-- Footer content here -->

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
