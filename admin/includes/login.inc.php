<?php
include('../../db.php');
include('admin_functions.php');

if(isset($_POST['submit'])){

    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $errorEmpty = false;
    $errorUname = false;
    $errorPass = false;
    $errorUnameExists = false;
    $errorIncPass = false;
    $errorVerify = false;


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
    // else if(!password_verify($pass, usernameexists($conn, $uname)['password'])){

    //     $errorIncPass = true;

    //     echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    //     <strong>Incorrect Password!</strong><br> Please make sure you entered a correct password.
    //     <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    //   </div>";
    // }

   
    else{
     

        $userexist = usernameexists($conn, $uname);

        session_start();
        $_SESSION["admin_ID"] = $userexist['admin_ID'];
        $_SESSION["admin_username"] = $userexist['username'];
        $_SESSION["admin_fname"] = $userexist['fname'];
        $_SESSION["admin_mname"] = $userexist['mname'];
        $_SESSION["admin_lname"] = $userexist['lname'];

        echo "<script>  window.location.href = 'home.php'; </script>";
        exit();


    }

}
else{
    echo "Error";
}


?>

<script>

$("#unamelogin,#passlogin,#btnlogin").removeClass("is-invalid");
var errorEmpty = "<?php echo $errorEmpty; ?>";
var errorUname = "<?php echo $errorUname; ?>";

var errorPass = "<?php echo $errorPass; ?>";
var errorUnameExists = "<?php echo $errorUnameExists; ?>";
var errorIncPass = "<?php echo $errorIncPass; ?>";

if(errorEmpty == true){
    if(errorUname == true){
        $("#unamelogin").addClass("is-invalid");
    }
    if(errorPass== true){
        $("#passlogin").addClass("is-invalid");
    }
}

else if(errorUnameExists == true){
    $("#unamelogin").addClass("is-invalid");
}
else if(errorIncPass == true){
    $("#passlogin").addClass("is-invalid");
}



</script>