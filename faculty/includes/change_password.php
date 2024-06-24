<?php 
session_start();
include "../../db.php";
include "faculty_functions.php";
if(isset($_POST['submit'])){
   $id = $_POST['id'];

    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $cpass = $_POST['cpass'];


    $erroroldpass = false;
    $errornewpass = false;
    $errorcpass = false;
    $errorCpass = false;
    $errorEmpty = false;
    $errorIncPass = false;


    if( empty($oldpass) ||empty($newpass) || empty($cpass) ){

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Please fill in all important details!</strong><br> You should check in on some of those fields below.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";

      $errorEmpty = true;
      if(empty($oldpass)){
        $erroroldpass=true;
    }

      if(empty($newpass)){
        $errornewpass=true;
    }
    
    if(empty($cpass)){
        $errorcpass=true;
    }
    }
    
    else if(!password_verify($oldpass, userinfo($conn,$_SESSION['faculty_ID'])['pass'])){

        $errorIncPass = true;

        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Incorrect Password!</strong><br> Please make sure you entered a correct password.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    // else if($oldpass != userinfo($conn,$_SESSION['admin_ID'])->password){

    //     $errorIncPass = true;

    //     echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    //     <strong>Incorrect Password!</strong><br> Please make sure you entered a correct password.
    //     <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    //   </div>";
    // }
    else if($newpass!=$cpass){
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Password Mismatch!</strong><br> Please make sure that you entered the same password.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      $errorCpass=true;
    }


    
    else{

    
      $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);;
     $userid = $id;
     $sql="UPDATE faculty SET  pass = '$hashed_password'
                             WHERE faculty_ID = $userid
                              ;";
     
     mysqli_query($conn,$sql);
     
     mysqli_close($conn);
     
     echo "
     <script> 
     
     Swal.fire({
         title: 'Success!',
         text: 'Your password has been changed successfully.',
         icon: 'success',
         confirmButtonColor: '#d9534f',
     
       }); 
       let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
         window.location.href = 'profile.php'
       })
     
       
       </script>";
    }
     
     
    }
  

  

?>
<script>
 $("#oldpass,#newpass,#cpass").removeClass("is-invalid");
 var erroroldpass = "<?php echo $erroroldpass; ?>";
 var errornewpass = "<?php echo $errornewpass; ?>";
 var errorcpass = "<?php echo $errorcpass; ?>";
 var errorCpass = "<?php echo $errorCpass; ?>";
 var errorEmpty = "<?php echo $errorEmpty; ?>";
 var errorIncPass = "<?php echo $errorIncPass; ?>";


     
       

 if(errorEmpty == true){

    if(erroroldpass == true){
            $("#oldpass").addClass("is-invalid");
        }

    if(errornewpass == true){
            $("#newpass").addClass("is-invalid");
        }

        if(errorcpass == true){
            $("#cpass").addClass("is-invalid");
        }


 }
 else if(errorIncPass == true){
    
    $("#oldpass").addClass("is-invalid");
   
 }
 
 else if(errorCpass == true){
    
    $("#newpass").addClass("is-invalid");
    $("#cpass").addClass("is-invalid");
 }
</script>