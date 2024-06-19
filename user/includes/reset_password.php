<?php 
session_start();
include "../../db.php";
include "users_functions.php";
if(isset($_POST['submit'])){


  
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $cpass = $_POST['cpass'];

  $errorCpass = false;
  $errorpass = false;



  if( empty($pass) || empty($cpass) ){

    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Please fill in all important details!</strong><br> You should check in on some of those fields below.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  if(empty($pass)){
    $errorpass=true;
}

if(empty($cpass)){
    $errorcpass=true;
}

}

else if($pass!=$cpass){
  echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
  <strong>Password Mismatch!</strong><br> Please make sure that you entered the same password.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
$errorCpass=true;
}

else{

      
  $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
     $sql="UPDATE users SET 
                           
                             u_pass= '$hashed_password'
                           
                             WHERE u_email = '$email'
                              ;";
     
     mysqli_query($conn,$sql);
     
     mysqli_close($conn);
     
     echo "
     <script> 
     
     Swal.fire({
         title: 'Success!',
         text: 'Your password has been successfully reset! You can now log in with your new password.',
         icon: 'success',
         confirmButtonColor: '#d9534f',
     
       }); 
       let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
         window.location.href = 'index.php'
       })
     
       
       </script>";
     
     
    }
  }

  

?>
<script>
 $("#pass,#cpass").removeClass("is-invalid");
 var errorpass = "<?php echo $errorpass; ?>";
 if(errorpass == true){
    $("#pass").addClass("is-invalid");
    $("#cpass").addClass("is-invalid");
 }
</script>