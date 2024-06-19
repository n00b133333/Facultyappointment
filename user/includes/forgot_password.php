<?php
include "../../db.php";
include "users_functions.php";
require '../../vendor/autoload.php'; // Adjust the path as necessary

if(isset($_POST['submit'])){
 
  
$email = $_POST['email'];


$errorEmpty = false;
$errorEmail = false;

$erroremail = false;

if(empty($email)){

    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Please fill in all important details!</strong><br> You should check in on some of those fields.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";


if(empty($email)){
    $erroremail=true;
}


    $errorEmpty = true;
}





 else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Invalid email address!</strong><br> You should write a valid email address.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    $errorEmail = true;
}





else{

    $otp = otppass( $email, $conn);
    if ($otp !== false) {
        if (forgotPasswordEmail($email, $otp)) {
           
            echo "
            <script> 
        
            Swal.fire({
                title: 'Success!',
                text: ' An OTP has been sent to your email.',
                icon: 'success',
            
              }); 
              let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
                window.location.href = 'reset_verify.php?email=".$email."'
              })
            
              
              </script>";
        } else {
            echo "User registered successfully! However, the OTP email could not be sent.";
        }
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
       <strong>Invalid email address!</strong><br>The email address you entered does not exist.

        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
  
      
    
}

}
else{
    echo "Errors";
}

?>

<script>
    $("#email").removeClass("is-invalid");
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    
    var erroremail = "<?php echo $erroremail; ?>";
    

    if(errorEmpty == true){
      
        if(erroremail == true){
            $("#email").addClass("is-invalid");
        }


    

    }

    if(errorEmail == true){
        $("#email").addClass("is-invalid");
    }

    

   

    if(errorEmpty == false && errorEmail == false ){
        $("#email").val("");
    }
  


</script>







