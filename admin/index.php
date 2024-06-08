<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h2 class="text-center">Login</h2>
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            // Dummy credentials for demonstration purposes
                            $valid_username = 'user';
                            $valid_password = 'password';

                            if ($username === $valid_username && $password === $valid_password) {
                                header('Location: dashboard.php');
                                exit();
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Invalid credentials, please try again.</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
