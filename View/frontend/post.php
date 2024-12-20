<?php



include_once '../../Controller/article_ctrl.php'; // Inclure la classe ArticleController
include_once '../../View/config.php';

// Récupérer l'ID de l'article depuis le paramètre URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Créer une connexion à la base de données en utilisant la classe Config
    $conn = Config::getConnexion();

    // Instancier la classe ArticleController
    $articleCtrl = new ArticleController($conn);

    // Récupérer les détails de l'article en fonction de l'ID
    $query = "SELECT * FROM Article WHERE id = :id";
    $sql = $conn->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $article = $sql->fetch();
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="OnlyTo7fa">
    <link rel="shortcut icon" href="favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css?v=1.1" rel="stylesheet">
    <title><?php echo htmlspecialchars($article['titre']); ?> - OnlyTo7fa Blog</title>

</head>

<body>

<!-- Début de l'En-tête / Navigation -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.html">OnlyTo7fa<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsOnlyTo7fa">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsOnlyTo7fa">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
                <li><a class="nav-link" href="shop.html">Boutique</a></li>
                <li><a class="nav-link" href="about.html">À propos de nous</a></li>
                <li><a class="nav-link" href="services.html">Services</a></li>
                <li><a class="nav-link" href="blog.php">Blog</a></li>
                <li><a class="nav-link" href="contact.html">Contactez-nous</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Fin de l'En-tête / Navigation -->

<!-- Début de la Section Article -->
<div class="single-post">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="post-entry">
                    <!-- Titre de l'article -->
                    <h1><?php echo htmlspecialchars($article['titre']); ?></h1>
                    <!-- Image de l'article -->
                    <img src="images/<?php echo htmlspecialchars($article['picture']); ?>" alt="Image" class="img-fluid mb-4">
                    
                    <!-- Contenu de l'article -->
                    <h3 class="post-meta">
                        <span>par <a href="#">Admin</a></span> &bullet;
                        <span><?php echo date('j F Y', strtotime($article['date_pub'])); ?></span> &bullet;
                        <span>Catégorie : <?php echo htmlspecialchars($article['categorie']); ?></span>
                    </h3>
                    <div class="post-content">
                        <h3><?php echo nl2br(htmlspecialchars($article['contenu'])); ?></h3>
                    </div>
                </div>
            </div>

            <!-- Début de la Section Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h3>À propos de OnlyTo7fa</h3>
                        <p>Votre destination pour des meubles intemporels et des conceptions d'intérieur qui reflètent votre style unique.</p>
                    </div>
                    <div class="sidebar-widget">
                        <h3>Suivez-nous</h3>
                        <ul class="social-links">
                            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Fin de la Section Sidebar -->
        </div>
    </div>
</div>
<!-- Fin de la Section Article -->

<!-- Début de la Section Pied de page -->
<footer class="site-footer bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h3>À propos de OnlyTo7fa</h3>
                <p>Votre destination pour des meubles intemporels et des conceptions d'intérieur qui reflètent votre style unique.</p>
            </div>
            <div class="col-lg-4">
                <h3>Newsletter</h3>
                <p>Inscrivez-vous à notre newsletter pour obtenir les dernières mises à jour et réductions !</p>
            </div>
            <div class="col-lg-4">
                <h3>Suivez-nous</h3>
                <ul class="social-links">
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- Fin de la Section Pied de page -->

<!-- Scripts JS -->
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/script.js"></script>
</body>

</html>
