<?php
// Include necessary files
include_once '../../Controller/userC.php';
include_once '../../View/config.php';
$db = Config::getConnexion();
$userController = new UserController($db);
$submission_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get sanitized input
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $tel = htmlspecialchars(trim($_POST['tel']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $sexe = htmlspecialchars(trim($_POST['sexe']));
    $dateNai = htmlspecialchars(trim($_POST['date_nai']));
    $role = htmlspecialchars(trim($_POST['role']));
    $password = $_POST['password'];

    // Validate the inputs
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($nom) && !empty($prenom) && !empty($password)) {
        if ($userController->create($nom, $prenom, $email, $tel, $adresse, $sexe, $dateNai, $role, $password)) {
            $submission_message = "Inscription réussie!";
        } else {
            $submission_message = "Une erreur est survenue. Veuillez réessayer.";
        }
    } else {
        $submission_message = "Veuillez remplir tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - SB Admin 2</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
    /* Remove background color from the .bg-gradient-primary class if it's already being applied */
    .bg-gradient-primary {
        background-color: transparent !important; /* Remove the existing background from this class */
    }

    /* Set the custom background color for the body */
    body {
        background-color: #6b210a !important; /* Set the background color of the entire page */
    }

    /* Optional: Other styles to ensure visibility and contrast */
    .text-gray-900 {
        color: #6b210a !important;
    }

    .btn-primary {
        background-color: #6b210a !important;
        border-color: #6b210a !important;
    }

    .error-message {
        color: #6b210a;
        font-weight: bold;
    }
    .bg-login-image {
    background-image: url('./images/NST1.png');
    background-size: cover;
    background-position: center 40px; /* Shift the image slightly down */
    height: 50vh;
    width: 50%;
    display: block;
}
</style>
</head>
<body ">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form method="POST" action="login.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="nom" placeholder="Nom" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="prenom" placeholder="Prénom" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" placeholder="E-mail" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="Mot de passe" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="tel" placeholder="Numéro de téléphone">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="adresse" placeholder="Adresse">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="sexe" required>
                                                <option value="Homme">Homme</option>
                                                <option value="Femme">Femme</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="date_nai" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="role" required>
                                                <option value="Utilisateur">Utilisateur</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">S'inscrire</button>
                                    </form>

                                    <?php if ($submission_message): ?>
                                        <p><?php echo $submission_message; ?></p>
                                    <?php endif; ?>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
