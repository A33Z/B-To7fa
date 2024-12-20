<?php
include_once '../../View/config.php';
include_once '../../Controller/article_ctrl.php';
include_once '../../Controller/commentaireC.php';

$conn = Config::getConnexion();
$commentCtrl = new CommentaireController($conn);
$articleCtrl = new ArticleController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_a'])) {
    $article_id = intval($_POST['id_a']);
    $name = htmlspecialchars($_POST['name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $article = $articleCtrl->getArticleById($article_id);

    if (!$article) {
        die("Article introuvable !");
    }

    if ($commentCtrl->create($name, $last_name, $email, $message, $article_id)) {
        header("Location: post.php?id=$article_id");
        exit();
    } else {
        die("Erreur lors de l'ajout du commentaire !");
    }
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $article = $articleCtrl->getArticleById($id);
    if (!$article) {
        die("Article introuvable !");
    }
} else {
    die("Aucun article sélectionné !");
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($article['titre']); ?> - B-TO7FA Blog</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css?v=1.1" rel="stylesheet">
</head>
<body>
 <!--header section-->
 		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

			<div class="container">
				<a class="navbar-brand" href="index.html">B-TO7FA<span>.</span></a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li class="nav-item ">
							<a class="nav-link" href="index.html">Acceuill</a>
						</li>
						<li><a class="nav-link" href="shop.php">Boutique</a></li>
						<li><a class="nav-link" href="about.html">A propos de nous</a></li>
						<li><a class="nav-link" href="services.html">Services</a></li>
						<li><a class="nav-link" href="blog.php">Blog</a></li>
						<li><a class="nav-link" href="commentaire.php">Contacter-nous</a></li>
					</ul>

					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
						<li><a class="nav-link" href="#"><img src="images/user.svg"></a></li>
						<li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>
					</ul>
				</div>
			</div>
		</nav>

<div class="single-post container">
    <center><h1><?php echo htmlspecialchars($article['titre']); ?></h1></center>
    <center><img src="./images/<?php echo htmlspecialchars($article['picture']); ?>" alt="Image" class="img-fluid mb-4"></center>
    <h6 class="post-meta">
        <span><?php echo date('j F Y', strtotime($article['date_pub'])); ?></span> &bullet;
    </h6>
    <h3><p><?php echo nl2br(htmlspecialchars($article['contenu'], ENT_QUOTES, 'UTF-8')); ?></p></h3>
</div>

<div class="container comment-section">
    <center><h3>Laisser un commentaire</h3></center>
    <form action="post.php" method="POST">
        <input type="hidden" name="id_a" value="<?php echo $article['id']; ?>">

        <div class="mb-3">
            <label for="name">Prénom</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="message">Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <h3>Commentaires</h3>
    <?php
    $comments = $commentCtrl->getAll($article['id'])->fetchAll();

    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            echo "<div class='comment'>
                    <h5>" . htmlspecialchars($comment['name']) . " " . htmlspecialchars($comment['last_name']) . "</h5>
                    <p>" . nl2br(htmlspecialchars($comment['message'])) . "</p>
                    <small>" . htmlspecialchars($comment['email']) . "</small>
                  </div><hr>";
        }
    } else {
        echo "<p>Aucun commentaire pour le moment. Soyez le premier !</p>";
    }
    ?>
</div>

<footer class="footer-section">
    <div class="container relative">
        <div class="row">
            <div class="col-lg-8">
                <div class="subscription-form">
                    <h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>S'inscrire Ici</span></h3>
                    <form action="#" class="row g-3">
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="entrez votre nom">
                        </div>
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="entrez votre email">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-5 mb-5">
            <div class="col-lg-4">
                <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">To7fa<span>.</span></a></div>
                <p class="mb-4">"Si vous avez d'autres questions ou souhaitez obtenir davantage d'informations, n'hésitez pas à nous contacter. Nous serons ravis de vous aider et de répondre à toutes vos demandes avec le plus grand respect."</p>

                <ul class="list-unstyled custom-social">
                    <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
                </ul>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
                <ul class="list-unstyled">
                    <li><a href="#">à propos de nous </a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">contactez nous</a></li>
                </ul>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
                <ul class="list-unstyled">
                    <li><a href="#">boutique</a></li>
                    <li><a href="#">acceuil</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-top copyright">
        <div class="row pt-4">
            <div class="col-lg-6">
                <p class="mb-2 text-center text-lg-start">"Votre confiance est notre moteur, ensemble, faisons de chaque défi une réussite !"</p>
            </div>
        </div>
    </div>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
