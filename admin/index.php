<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Appointment System</title>
  
    <link rel="stylesheet" href="assets/css/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<style>
      .form-message {
            position: fixed;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
         
            color: white;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
            margin-bottom: 10px;
            
        }
</style>
    

    <script>
        $(document).ready(function(){


            $("form").submit(function(event){

                event.preventDefault();
                var uname = $("#username").val();
                var pass = $("#password").val();
                var submit = $("#btnlogin").val();

                $(".form-message").load("includes/login.inc.php", {
                    uname:uname,
                    pass:pass,
                    submit:submit
                })
            })

        })
    </script>  


</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="form-message"></div>
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="text-center">
                
                        <img src="../img/logo.png" alt="" height="80" width="80">
                        </div>
                        <h2 class="text-center">ADMIN LOGIN</h2>
                        <form action="includes/login.inc.php" method="post">
                            <div class="form-group mt-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" >
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" >
                            </div>
                            <div class="text-center">
                            <button type="submit" id="btnlogin" class="btn btn-danger mt-3" style="width: 100%;">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
