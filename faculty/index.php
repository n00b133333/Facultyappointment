

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign in</title>
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
        body {
            font-family: 'Rubik'!important;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh; /* Ensure the body takes full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;

            background-image: url('../img/aitup.png');
            background-size: cover; /* Cover the entire container */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
        }

        .form-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
         
            color: white;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
        }
        
        .glass{ 
   
/* From https://css.glass */
background: rgba(0, 0, 0, 0.5);
border-radius: 5px;
box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
backdrop-filter: blur(5px);
-webkit-backdrop-filter: blur(5px);
border: 1px solid rgba(0, 0, 0, 0.3);
padding: 20px;
} 

/* .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control,.form-select {
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            padding: 0.375rem 0;
            width: 100%;
            background-color: transparent;
            font-size: 1rem;
            color: #495057;
        }

        .form-control:focus,.form-select:focus {
            outline: none;
            box-shadow: none;
            border-bottom-color: #007bff;
        }

        .form-control:focus + label,
        .form-control:not(:placeholder-shown) + label, .form-select:focus + label,
        .form-select:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem);
            font-size: 0.75rem;
            color: #007bff;
        }

        label {
            position: absolute;
            top: 0.375rem;
            left: 0;
            font-size: 1rem;
            color: #6c757d;
            pointer-events: none;
            transition: all 0.2s ease-in-out;
        }

        /* Prevent showing placeholder text */
        /* .form-control::placeholder,.form-select::placeholder {
            color: transparent;
        }  */
    </style>

    
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
</head>
<body>
    <div class="contain">
        <div class="left">
          
        </div>
        <div class="right">
            
            <div class=" glass text-center ">
            <h2 class="mb-3" style="color:whitesmoke">Faculty Login</h2>
            <form action="includes/sign_up.php" method="post">

           

<div class="col">

<div class="form-floating mb-3">
<input type="text" class="form-control" id="unamelogin" placeholder="name@example.com" name="uname">
<label for="email">Email</label>
</div>

</div>
<div class="col">

<div class="form-floating mb-3">
<input type="password" class="form-control" id="passlogin" placeholder="name@example.com" name="pass">
<label for="pass">Password</label>
</div>

</div>




<div class="col">

<button type="submit" class="btn btn-danger px-4 mb-3" id="btnlogin"> LOGIN</button>




</div>

            


            </form>

           
            </div>
        </div>
    </div>
    <div class="form-message "></div>
</body>
</html>
