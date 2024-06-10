<?php
include ('../db.php');
include ('includes/users_functions.php');

if(isset($_POST["verify"])) {
    $uname = $_POST["username"];
    $otp = $_POST["otp"];

    if (verifyOTP($uname, $otp, $conn)) {
        echo "OTP verified successfully! Your account is now active.";
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h2 class="text-center">Verify Account</h2>
                        <form action="verify.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="otp">OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="verify">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
