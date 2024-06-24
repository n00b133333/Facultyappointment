<?php 
session_start();
include "../../db.php";
include "users_functions.php";
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
              $profilepic = userinfo($conn,$id)['profile'];
          }
      }
      else{
         $profilepic = userinfo($conn,$id)['profile'];
      }
      $userid = $id;
      $sql="UPDATE users SET u_fname = '$fname',
                              u_lname = '$lname',
                              u_mname = '$midname',
                              gender= '$gender',
                              u_email= '$email',
                              address= '$address',
                              contact_number= '$pnum',
                              bday= '$bday',
                              u_username= '$uname',
                              profile = '$profilepic'
                              WHERE user_ID = $userid
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