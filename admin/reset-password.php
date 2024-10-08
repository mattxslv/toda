<?php
require 'includes/dbconfig.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expires = new DateTime($row['expires']);
        $now = new DateTime();

        // Check if the token has expired
        if ($now < $expires) {
            // Token is valid, display the password reset form
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Reset Password</title>
                <!-- Custom fonts for this template-->
                <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
                <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                <!-- Custom styles for this template-->
                <link href="css/sb-admin-2.min.css" rel="stylesheet">
            </head>

            <body class="bg-gradient-primary">

                <div class="container">

                    <!-- Outer Row -->
                    <div class="row justify-content-center">

                        <div class="col-xl-10 col-lg-12 col-md-9">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body p-0">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                                        <div class="col-lg-6">
                                            <div class="p-5 text-center">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                                                    <p class="mb-4">Please enter your new password below.</p>
                                                </div>
                                                <form class="user" action="reset-password.php" method="POST">
                                                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                                    <div class="form-group">
                                                        <input type="password" class="form-control form-control-user" id="password" placeholder="Enter New Password..." name="password" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        Reset Password
                                                    </button>
                                                </form>
                                                <hr>
                                                <div class="text-center">
                                                    <a class="small" href="register.php">Create an Account!</a>
                                                </div>
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

                <!-- Bootstrap core JavaScript-->
                <script src="vendor/jquery/jquery.min.js"></script>
                <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="js/sb-admin-2.min.js"></script>

            </body>

            </html>
            <?php
        } else {
            echo "The token has expired.";
        }
    } else {
        echo "Invalid token.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();

        // Delete the token from the database
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid token.";
    }
} else {
    echo "Invalid request.";
}
?>