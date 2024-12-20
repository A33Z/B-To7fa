<?php
// Include necessary files
include_once '../../Controller/userC.php';
include_once '../../Model/userM.php';
include_once '../../View/config.php';
// Initialize variables
$db = Config::getConnexion();
$userController = new UserController($db);
$login_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        // Attempt to log in
        $user = $userController->login($email, $password);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user; 
            $_SESSION['user_id'] = $user->getId();
            if ($user->getRole() === 'Admin') {
                header("Location: backend.php");
                exit;
            } else {
                header("Location: ./../frontend/index.html");
                exit;
            }
        } else {
            $login_message = "Identifiants incorrects!";
        }
    } else {
        $login_message = "Veuillez remplir tous les champs!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SB Admin 2</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Set the background color for the body */
        body {
            background-color: #6b210a !important; /* Set the background color of the entire page */
            height: 100vh; /* Ensure full height */
            margin: 0; /* Remove default margin */
            display: flex; /* Use flexbox */
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center */
        }

        /* Outer row (flexbox for centering) */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Inner row structure */
        .row {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 1000px; /* Set a max width */
        }

        /* Card */
        .card {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 800px; /* Adjust width */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
            
        }

        /* Left side image */
        .bg-login-image {
            background-image: url('./images/NST1.png');
            background-size: cover; 
            background-position: left;
            height: 34vh; 
            width: 50%; 
            display: block;
            
            
           
}

        /* Right side login form */
        .col-lg-6 {
            padding: 40px; /* Add some padding */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Form elements */
        .form-control {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #6b210a !important;
            border-color: #6b210a !important;
        }

        /* Error message style */
        .error-message {
            color: #6b210a;
            font-weight: bold;
        }

        /* Optional styles for text */
        .text-gray-900 {
            color: #6b210a !important;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <!-- Left side image -->
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>

                        <!-- Right side login form -->
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form method="POST" action="login.php">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="Enter Email Address..." required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>

                                <?php if ($login_message): ?>
                                    <p class="error-message"><?php echo $login_message; ?></p>
                                <?php endif; ?>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="signup.php">Create an Account!</a>
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
