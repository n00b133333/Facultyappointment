<?php
include('../../db.php');
include('faculty_functions.php');

if(isset($_POST['submit'])){


    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $errorEmpty = false;
    $erroremail = false;
    $errorPass = false;
    $erroremailExists = false;
    $errorIncPass = false;
    $errorVerify = false;

    

    if(empty($email) || empty($pass)){
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Please fill in all Fields!</strong><br> You should check in on some of those fields below.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  $errorEmpty = true;
        if(empty($email)){
            $erroremail = true;
        }
        if(empty($pass)){
            $errorPass = true;
        }
    }

    else if(usernameexists($conn, $email)=== false){

        $erroremailExists = true;

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Invalid Username!</strong><br> The username you entered is invalid.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";

    }
    else if(!password_verify($pass, usernameexists($conn, $email)['pass'])){

        $errorIncPass = true;

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Incorrect Password!</strong><br> Please make sure you entered a correct password.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

  

    
 else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Invalid email address!</strong><br> You should write a valid email address.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    $errorEmail = true;
}
    else{
     

        $userexist = usernameexists($conn, $email);

        session_start();
        $_SESSION["faculty_ID"] = $userexist['faculty_ID'];
        $_SESSION["faculty_email"] = $userexist['faculty_email'];
        $_SESSION["faculty_fname"] = $userexist['faculty_fname'];
        $_SESSION["faculty_mname"] = $userexist['faculty_mname'];
        $_SESSION["faculty_lname"] = $userexist['faculty_lname'];

        echo "<script>  window.location.href = 'home.php'; </script>";
        exit();


    }

}
else{
    echo "Error";
}


?>

<script>
   
$("#emaillogin,#passlogin,#btnlogin").removeClass("is-invalid");
var errorEmpty = "<?php echo $errorEmpty; ?>";
var erroremail = "<?php echo $erroremail; ?>";
var errorPass = "<?php echo $errorPass; ?>";
var erroremailExists = "<?php echo $erroremailExists; ?>";
var errorIncPass = "<?php echo $errorIncPass; ?>";

if(errorEmpty == true){
    if(erroremail == true){
        $("#emaillogin").addClass("is-invalid");
    }
    if(errorPass== true){
        $("#passlogin").addClass("is-invalid");
    }
}

else if(erroremailExists == true){
    $("#emaillogin").addClass("is-invalid");
}
else if(errorIncPass == true){
    $("#passlogin").addClass("is-invalid");
}



</script>