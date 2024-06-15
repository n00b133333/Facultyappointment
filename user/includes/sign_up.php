<?php
include "../../db.php";
include "users_functions.php";
require '../../vendor/autoload.php'; // Adjust the path as necessary

if(isset($_POST['submit'])){
 
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$bday = $_POST['bday'];
$gender = $_POST['gender'];    
$email = $_POST['email'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$uname = $_POST['uname'];
$pass= $_POST['pass'];
$cpass= $_POST['cpass'];

$errorEmpty = false;
$errorEmail = false;
$errorCpass = false;
$errorContact = false;

$errorfname = false;
$errorlname = false;
$errorbday = false;
$erroremail = false;
$errorcontact = false;
$erroraddress = false;
$erroruname = false;
$errorpass = false;
$errorcpass = false;
$userExist = false;

if(empty($fname) || empty($mname) || empty($lname) || empty($bday) || empty($contact)  || empty($uname) || empty($pass) || empty($cpass) || empty($email) || empty($address) ){

    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Please fill in all important details!</strong><br> You should check in on some of those fields.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
if(empty($fname)){
    $errorfname=true;
}


if(empty($mname)){
    $errormname=true;
}

if(empty($lname)){
    $errorlname=true;

}

if(empty($bday)){
    $errorbday=true;
  
}

if(empty($contact)){
    $errorcontact=true;
}

if(empty($email)){
    $erroremail=true;
}

if(empty($uname)){
    $erroruname=true;
}

if(empty($address)){
    $erroraddress=true;
}

if(empty($pass)){
    $errorpass=true;
}

if(empty($cpass)){
    $errorcpass=true;
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

else if(!is_numeric($contact) || strlen($contact)!=11){
    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Invalid Contact Number!</strong><br> Please make sure you entered a valid contact number .
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    $errorContact = true;
}

else if(usernameexists($conn, $uname)){
    $userExist = true;
    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Username Already Exists!</strong><br> Please write another username.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}


else if($pass!=$cpass){
    echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
    <strong>Password Mismatch!</strong><br> Please make sure that you entered the same password.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  $errorCpass=true;
}


else{

    $otp = register($fname, $mname, $lname, $address,$gender,$contact,$bday, $uname, $pass, $email, $conn);
    if ($otp !== false) {
        if (sendConfirmationEmail($email, $otp)) {
           
            echo "
            <script> 
        
            Swal.fire({
                title: 'Success!',
                text: 'User registered successfully! An OTP has been sent to your email.',
                icon: 'success',
            
              }); 
              let button = document.querySelectorAll('.swal2-confirm').forEach(a=>a.onclick =function (){
                window.location.href = 'verify.php'
              })
            
              
              </script>";
        } else {
            echo "User registered successfully! However, the OTP email could not be sent.";
        }
    } else {
        echo "Registration failed.";
    }
  
      
    
}

}
else{
    echo "Error";
}

?>

<script>
    $("#fname,#lname,#bday,#email,#contact,#address,#uname,#pass,#cpass").removeClass("is-invalid");
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorContact = "<?php echo $errorContact; ?>";


    var errorfname = "<?php echo $errorfname; ?>";
    var errormname = "<?php echo $errormname; ?>";
    var errorlname = "<?php echo $errorlname; ?>";
    var errorbday = "<?php echo $errorbday; ?>";
    var erroremail = "<?php echo $erroremail; ?>";
    var erroraddress = "<?php echo $erroraddress; ?>";
    var errorcontact = "<?php echo $errorcontact; ?>";
    var erroruname = "<?php echo $erroruname; ?>";
    var errorpass = "<?php echo $errorpass; ?>";
    var errorcpass = "<?php echo $errorcpass; ?>";
    var errorCpass = "<?php echo $errorCpass; ?>";
    var errorExist = "<?php echo $userExist; ?>";

    if(errorEmpty == true){
        if(errorfname == true){
            $("#fname").addClass("is-invalid");
        }

        if(errormname == true){
            $("#mname").addClass("is-invalid");
        }
        if(errorlname == true){
            $("#lname").addClass("is-invalid");
        }

        if(errorbday == true){
            $("#bday").addClass("is-invalid");
        }

        if(erroremail == true){
            $("#email").addClass("is-invalid");
        }

        if(erroraddress == true){
            $("#address").addClass("is-invalid");
        }

        if(errorcontact == true){
            $("#contact").addClass("is-invalid");
        }

        if(erroruname == true){
            $("#uname").addClass("is-invalid");
        }

        if(errorpass == true){
            $("#pass").addClass("is-invalid");
        }

        if(errorcpass == true){
            $("#cpass").addClass("is-invalid");
        }

    }

    if(errorEmail == true){
        $("#email").addClass("is-invalid");
    }

    if(errorCpass == true){
        $("#cpass").addClass("is-invalid");
    }

    if(errorExist == true){
        $("#uname").addClass("is-invalid");
    }

    if(errorContact == true){
        $("#contact").addClass("is-invalid");
    }

   

    if(errorEmpty == false && errorEmail == false && errorCpass == false && errorExist == false && errorContact == false){
        $("#fname,#lname,#bday,#email,#contact,#address,#uname,#pass,#cpass").val("");
    }
  


</script>







