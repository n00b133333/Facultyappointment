<?php
include('../../db.php');
include('admin_functions.php');

if(isset($_POST['submit'])){

    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $errorEmpty = false;
    $errorUname = false;
    $errorUnameExists = false;
    $errorIncPass = false;
    $errorPass =false;


    if(empty($uname) || empty($pass)){
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Please fill in all Fields!</strong><br> You should check in on some of those fields below.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  $errorEmpty = true;
        if(empty($uname)){
            $errorUname = true;
        }
        if(empty($pass)){
            $errorPass = true;
        }
    }

    else if(usernameexists($conn, $uname)=== false){

        $errorUnameExists = true;

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Invalid Username!</strong><br> The username you entered is invalid.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";

    }
    else if(!password_verify($pass, usernameexists($conn, $uname)['password'])){

        $errorIncPass = true;

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Incorrect Username or Password!</strong><br> Please make sure you entered the correct credentials.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

   
    else{
     

        $userexist = usernameexists($conn, $uname);

        session_start();
        $_SESSION["admin_ID"] = $userexist['admin_ID'];
        $_SESSION["admin_username"] = $userexist['username'];
        $_SESSION["admin_fname"] = $userexist['fname'];
        $_SESSION["admin_mname"] = $userexist['mname'];
        $_SESSION["admin_lname"] = $userexist['lname'];

        echo "<script>  window.location.href = 'dashboard.php'; </script>";
        exit();


    }

}
else{
    echo "Error";
}


?>

<script>

$("#username,#password,#btnlogin").removeClass("is-invalid");
var errorEmpty = "<?php echo $errorEmpty; ?>";
var errorUname = "<?php echo $errorUname; ?>";
var errorPass = "<?php echo $errorPass; ?>";


var errorUnameExists = "<?php echo $errorUnameExists; ?>";
var errorIncPass = "<?php echo $errorIncPass; ?>";

if(errorEmpty == true){
    if(errorUname == true){
        $("#username").addClass("is-invalid");
    }
    if(errorPass== true){
        $("#password").addClass("is-invalid");
    }
}



else if(errorUnameExists == true){
    $("#username").addClass("is-invalid");
}
else if(errorIncPass == true){
    $("#username").addClass("is-invalid");
    $("#password").addClass("is-invalid");
}



</script>