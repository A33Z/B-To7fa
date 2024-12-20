<?php
include_once '../../Controller/article_ctrl.php'; 
include_once '../../View/config.php';


$conn = Config::getConnexion();


$articleCtrl = new ArticleController($conn);


$articles = $articleCtrl->getAll()->fetchAll();
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
  <link href="css/style.css" rel="stylesheet">
  <title>B-TO7FA - Blog</title>
</head>

<body>

<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.html">B-TO7FA<span>.</span></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsOnlyTo7fa">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsOnlyTo7fa">
      <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
        <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
        <li><a class="nav-link" href="shop.php">Boutique</a></li>
        <li><a class="nav-link" href="about.html">A propos de nous</a></li>
        <li><a class="nav-link" href="services.html">Services</a></li>
        <li class="active"><a class="nav-link" href="blog.php">Blog</a></li>
        <li><a class="nav-link" href="commentaire.php">Contactez-nous</a></li>
      </ul>
      <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
						<li><a class="nav-link" href="profile.php"><img src="images/user.svg"></a></li>
						<li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>
						<li><a class="nav-link" href="login.php">Déconnexion</a></li>
					</ul>
    </div>
  </div>
</nav>
<!-- Fin de l'En-tête / Navigation -->

<!-- Début de la Section Héro -->
<div class="hero">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-5">
        <div class="intro-excerpt">
          <h1>Blog</h1>
          <p class="mb-4">Explorez nos derniers articles de blog et conseils en design d'intérieur.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Fin de la Section Héro -->

<!-- Début de la Section Blog -->
<div class="blog-section">
  <div class="container">
    <div class="row">
      <?php foreach ($articles as $article): ?>
      <div class="col-12 col-sm-6 col-md-4 mb-5">
        <div class="post-entry">
          <a href="post.php?id=<?php echo $article['id']; ?>" class="post-thumbnail">
            <img src="images/<?php echo $article['picture']; ?>" alt="Image" class="img-fluid">
          </a>
          <div class="post-content-entry">
            <h3><a href="post.php?id=<?php echo $article['id']; ?>"><?php echo $article['titre']; ?></a></h3>
            <div class="meta">
              <span>par <a href="#">Admin</a></span> &bullet;
              <span><?php echo date('F j, Y', strtotime($article['date_pub'])); ?></span>
            </div>
            <p><?php echo substr($article['contenu'], 0, 150) . '...'; ?></p>
            <a href="post.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Lire la suite</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<!-- Fin de la Section Blog -->

<!-- Début de la Section Pied de page -->
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
								<div class="col-auto">
									<button class="btn btn-primary">
										<span class="fa fa-paper-plane"></span>
									</button>
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

			</div>
		</footer>
<!-- Fin de la Section Pied de page -->

<!-- Scripts JS -->
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/script.js"></script>
</body>
</html>
