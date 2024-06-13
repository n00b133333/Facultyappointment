<?php
include ('db.php');
include ('user/includes/users_functions.php');


if(isset($_POST["submit"])) {
    $uname = $_POST["username"];
    $pass = $_POST["password"];
    $email = $_POST["email"];

    $otp = register($uname, $pass, $email, $conn);
    if ($otp !== false) {
        if (sendConfirmationEmail($email, $otp)) {
            echo "<script>alert('User registered successfully! An OTP has been sent to your email'); window.location.href='user/verify.php';</script>";
        } else {
            echo "User registered successfully! However, the OTP email could not be sent.";
        }
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h2 class="text-center">Register</h2>
                        <form action="register.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
