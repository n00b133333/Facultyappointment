<?php 
session_start();
include "../../db.php";
include "admin_functions.php";
if(isset($_POST['submit'])){
   $id = $_POST['id'];
    $fname = $_POST['fname'];
    $midname = $_POST['midname'];
    $lname = $_POST['lname'];

    $email = $_POST['email'];
    $uname = $_POST['uname'];
 

    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $profilepic = "";

    $errorpass = false;

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
             $profilepic = editfacultyprofile($conn,$id)->profile;
         }
     }
     else{
        $profilepic = editfacultyprofile($conn,$id)->profile;
     }
     $userid = $id;
     $sql="UPDATE admin SET fname = '$fname',
                             lname = '$lname',
                             mname = '$midname',
                            
                             email= '$email',
                             username= '$uname',
                            
                          
                             profile = '$profilepic'
                             WHERE admin_ID = $userid
                              ;";
     
     mysqli_query($conn,$sql);
     
     mysqli_close($conn);
     
     echo "
     <script> 
     
     Swal.fire({
         title: 'Updated!',
         text: '',
         icon: 'success',
         confirmButtonColor: '#d9534f',
     
       }); 
       let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
         window.location.href = 'profile.php'
       })
     
       
       </script>";
     
     
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