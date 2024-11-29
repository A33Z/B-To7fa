<?php
include_once 'C:\xampp\htdocs\B-TO7FA\Controller\article_ctrl.php';
include_once 'C:\xampp\htdocs\B-TO7FA\Model\articleM.php';

$error = "";
$db = Config::getConnexion();
$articleController = new ArticleController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addArticle'])) {
        if (!empty($_POST['titre']) && !empty($_POST['contenu']) && !empty($_POST['date_pub']) && !empty($_POST['categorie'])) {
            $article = new Article(
                null,
                $_POST['titre'],
                $_POST['contenu'],
                $_POST['categorie'],
                $_POST['date_pub']
            );

            $isCreated = $articleController->create(
                $article->getTitre(),
                $article->getContenu(),
                $article->getCategorie(),
                $article->getDatePub()
            );

            if (!$isCreated) {
                $error = "Error while creating the article. Please try again.";
            }
        } else {
            $error = "Please fill in all fields.";
        }
    }

    if (isset($_POST['deleteArticle'])) {
        $articleController->delete($_POST['articleId']);
    }

    if (isset($_POST['updateArticle'])) {
        if (!empty($_POST['titre']) && !empty($_POST['contenu']) && !empty($_POST['date_pub']) && !empty($_POST['categorie'])) {
            $article = new Article(
                $_POST['articleId'],
                $_POST['titre'],
                $_POST['contenu'],
                $_POST['categorie'],
                $_POST['date_pub']
            );

            $isUpdated = $articleController->update(
                $article->getTitre(),
                $article->getContenu(),
                $article->getCategorie(),
                $article->getDatePub(),
                $_POST['articleId']
            );

            if (!$isUpdated) {
                $error = "Error while updating the article. Please try again.";
            }
        } else {
            $error = "Please fill in all fields for update.";
        }
    }
}

$articles = $articleController->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Travel Articles</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="./js2/js.js"></script>
</head>
<body>
<div class="container my-4">
    <h1 class="text-center mb-4">Manage Travel Articles</h1>
    <form action="article.php" method="POST" onsubmit="return validateForm(event)">
        <div class="form-group">
            <label for="titre">Title:</label>
            <input type="text" id="titre" name="titre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contenu">Content:</label>
            <textarea id="contenu" name="contenu" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="date_pub">Publication Date:</label>
            <input type="date" id="date_pub" name="date_pub" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="categorie">Category:</label>
            <select id="categorie" name="categorie" class="form-control" required>
                <option value="adventure">Adventure</option>
                <option value="relaxation">Relaxation</option>
                <option value="culture">Culture</option>
            </select>
        </div>
        <button type="submit" name="addArticle" class="btn btn-primary btn-block">Add Article</button>
    </form>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php endif; ?>
    <hr>
    <h2 class="text-center mt-4">Travel Articles</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Category</th>
                <th>Publication Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?php echo htmlspecialchars($article['id']); ?></td>
                    <td><?php echo htmlspecialchars($article['titre']); ?></td>
                    <td><?php echo htmlspecialchars($article['contenu']); ?></td>
                    <td><?php echo htmlspecialchars($article['categorie']); ?></td>
                    <td><?php echo htmlspecialchars($article['date_pub']); ?></td>
                    <td>
                        <form action="article.php" method="POST" style="display:inline;">
                            <input type="hidden" name="articleId" value="<?php echo htmlspecialchars($article['id']); ?>">
                            <button type="submit" name="deleteArticle" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <button class="btn btn-info btn-sm" onclick="populateForm(<?php echo htmlspecialchars(json_encode($article)); ?>)">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function populateForm(article) {
        document.getElementById('titre').value = article.titre;
        document.getElementById('contenu').value = article.contenu;
        document.getElementById('date_pub').value = article.date_pub;
        document.getElementById('categorie').value = article.categorie;
        
        let form = document.querySelector('form[action="article.php"]');
        form.innerHTML = ` 
            <div class="form-group">
                <label for="titre">Title:</label>
                <input type="text" id="titre" name="titre" class="form-control" required value="${article.titre}">
            </div>
            <div class="form-group">
                <label for="contenu">Content:</label>
                <textarea id="contenu" name="contenu" class="form-control" required>${article.contenu}</textarea>
            </div>
            <div class="form-group">
                <label for="date_pub">Publication Date:</label>
                <input type="date" id="date_pub" name="date_pub" class="form-control" required value="${article.date_pub}">
            </div>
            <div class="form-group">
                <label for="categorie">Category:</label>
                <select id="categorie" name="categorie" class="form-control" required>
                    <option value="adventure" ${article.categorie === 'adventure' ? 'selected' : ''}>Adventure</option>
                    <option value="relaxation" ${article.categorie === 'relaxation' ? 'selected' : ''}>Relaxation</option>
                    <option value="culture" ${article.categorie === 'culture' ? 'selected' : ''}>Culture</option>
                </select>
            </div>
            <input type="hidden" name="articleId" value="${article.ID}">
            <button type="submit" name="updateArticle" class="btn btn-warning btn-block">Update Article</button>
        `;
    }

</script>
</body>
</html>
