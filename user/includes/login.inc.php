<?php
include('../../db.php');
include('users_functions.php');

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
    else if(!password_verify($pass, usernameexists($conn, $uname)['u_pass'])){

        $errorIncPass = true;

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Incorrect Password or Email!</strong><br> Please make sure you entered the correct credentials.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    else if(usernameexists($conn, $uname)['status']==0){

        $errorVerify = true;

        echo " <script> 
        
            Swal.fire({
                title: 'Unverified Account!',
                text: ' Please verify your account.',
                icon: 'error',
                confirmButtonColor: '#d9534f',
            
              }); 
              let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
                window.location.href = 'verify.php'
              })
            
              
              </script>";
    }
    else{
     

        $userexist = usernameexists($conn, $uname);

        session_start();
        $_SESSION["user_ID"] = $userexist['user_ID'];
        $_SESSION["u_username"] = $userexist['u_username'];
        $_SESSION["u_fname"] = $userexist['u_fname'];
        $_SESSION["u_mname"] = $userexist['u_mname'];
        $_SESSION["u_lname"] = $userexist['u_lname'];

        echo "<script>  window.location.href = 'schedule.php'; </script>";
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
    $("#unamelogin").addClass("is-invalid");
}



</script>