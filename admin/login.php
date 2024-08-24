<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php'; // Include the Composer autoload file

// Google Client Configuration (remove this if not needed)
// $client = new Google_Client();
// $client->setClientId('YOUR_CLIENT_ID');
// $client->setClientSecret('YOUR_CLIENT_SECRET');
// $client->setRedirectUri('YOUR_REDIRECT_URI');
// $client->addScope('email');
// $client->addScope('profile');

// if (isset($_GET['code'])) {
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
//     if (isset($token['error'])) {
//         // Handle error
//         echo 'Error fetching access token: ' . $token['error'];
//         exit();
//     }

//     if (isset($token['access_token'])) {
//         $client->setAccessToken($token['access_token']);

//         // Get user profile data from Google
//         $google_oauth = new Google_Service_Oauth2($client);
//         $google_account_info = $google_oauth->userinfo->get();
//         $email = $google_account_info->email;
//         $name = $google_account_info->name;

//         // Replace with your actual database connection and query
//         $conn = new mysqli('localhost', 'root', '', 'adminpanel');

//         if ($conn->connect_error) {
//             die("Connection failed: " . $conn->connect_error);
//         }

//         // Check if the user exists in your database
//         $sql = "SELECT * FROM users WHERE email = '$email'";
//         $result = $conn->query($sql);

//         if ($result->num_rows > 0) {
//             $_SESSION['username'] = $email;
//             header("Location: dashboard.php");
//             exit();
//         } else {
//             // If user does not exist, you can create a new user or show an error
//             $_SESSION['status'] = "User does not exist. Please register.";
//         }

//         $conn->close();
//     } else {
//         echo 'Error: Access token not found.';
//         exit();
//     }
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Replace with your actual database connection and query
    $conn = new mysqli('localhost', 'root', '', 'adminpanel');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['status'] = "Invalid email or password";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page-->
    <style>
        .form-container {
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5 form-container">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['status'])) {
                                        echo '<div class="alert alert-danger">' . $_SESSION['status'] . '</div>';
                                        unset($_SESSION['status']);
                                    }
                                    ?>
                                    <form class="user" action="login.php" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
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
                                        
                                        <!-- Removed Google and Facebook login options -->
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.php">Forgot Password?</a>
                                        </div>
                                        
                                        <div class="text-center">
                                            <a class="small" href="register.php">Create an Account!</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
