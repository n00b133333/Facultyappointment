 <?php
//  session_start();
// if(isset($_SESSION["user_id"])){
//     header("Location: " . $_SERVER['HTTP_REFERER']);
//     exit();
// }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
<script>
        $(document).ready(function(){


            $("form").submit(function(event){

                event.preventDefault();
                var uname = $("#unamelogin").val();
                var pass = $("#passlogin").val();
                var submit = $("#btnlogin").val();

                $(".form-message").load("includes/login.inc.php", {
                    uname:uname,
                    pass:pass,
                    submit:submit
                })
            })

        })
    </script>

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h2 class="text-center">Login</h2>
                        <form action="includes/login.inc.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="unamelogin" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="passlogin" name="password" required>
                            </div>
                     
                            <button type="submit" class="btn btn-primary btn-block" id="btnlogin" name="submit">Login</button>
                        </form>
                        <p>Doesn't have an account? <a href="../register.php">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-message "></div>


    <?php include('includes/footer.php') ?>