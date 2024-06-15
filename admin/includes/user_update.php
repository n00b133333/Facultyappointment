<?php 
session_start();
include "../../includes/database.inc.php";
include "functions.admin.php";
if(isset($_POST['submit'])){
   $id = $_POST['id'];
    $fname = $_POST['fname'];
    $midname = $_POST['midname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $bday = $_POST['bday'];
    $address = $_POST['address'];
    $pnum = $_POST['pnum'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $profilepic = "";

    $errorpass = false;

    if($pass != $cpass){
        $errorpass = true;
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Please fill in all important details!</strong><br> You should check in on some of those fields below.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    }
    else{
        if(isset($_FILES['pic'])){
            $file = $_FILES['pic'];
         $fileName = $file['name'];
         $fileTmpName = $file['tmp_name'];
         $fileSize = $file['size'];
         $fileError = $file['error'];
         $fileType = $file['type'];
       
         $fileExt = explode('.',$fileName);
         $fileActExt = strtolower(end($fileExt));
       
       
         $allowed = array('jpg','jpeg','png','pdf','webp');
         if(in_array($fileActExt,$allowed)){
       
           if($fileError === 0){
       
         
               $profilepic = uniqid('',true).".".$fileActExt;
               $fileDestination = '../../uploads/'.$profilepic;
               move_uploaded_file($fileTmpName,$fileDestination);
               
            
           }else{
             echo "You have an Error";
           }
       
         }
         else{
             $profilepic = edituserprofile($conn,$id)->profile;
         }
     }
     else{
        $profilepic = edituserprofile($conn,$id)->profile;
     }
     $userid = $id;
     $sql="UPDATE user SET fname = '$fname',
                             lname = '$lname',
                             mid_name = '$midname',
                             gender= '$gender',
                             email= '$email',
                             address= '$address',
                             pnum= '$pnum',
                             bday= '$bday',
                             username= '$uname',
                             pass = '$pass',
                             profile = '$profilepic'
                             WHERE user_id = $userid
                              ;";
     
     mysqli_query($conn,$sql);
     
     mysqli_close($conn);
     
     echo "
     <script> 
     
     Swal.fire({
         title: 'Updated!',
         text: '',
         icon: 'success',
     
       }); 
       let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
         window.location.href = 'user.php'
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