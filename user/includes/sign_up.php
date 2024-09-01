<?php
include "../../db.php";
include "users_functions.php";
require '../../vendor/autoload.php'; // Adjust the path as necessary

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $bday = $_POST['bday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    $errorEmpty = false;
    $errorEmail = false;
    $errorCpass = false;
    $errorContact = false;
    $errorPass = false;

    $errorfname = false;
    $errorlname = false;
    $errorbday = false;
    $erroremail = false;
    $errorcontact = false;
    $erroraddress = false;
    $errorpass = false;
    $errorcpass = false;
    $userExist = false;

    // Generate username
    $year = date('y'); // Get the current year (last two digits)
    $orderNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // Generate a random order number
    $uname = "TUPT-$year-$orderNumber";

    // Validate fields
    if (empty($fname) || empty($mname) || empty($lname) || empty($bday) || empty($contact) || empty($pass) || empty($cpass) || empty($email) || empty($address)) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Please fill in all important details!</strong><br> You should check in on some of those fields.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";

        if (empty($fname)) $errorfname = true;
        if (empty($lname)) $errorlname = true;
        if (empty($bday)) $errorbday = true;
        if (empty($contact)) $errorcontact = true;
        if (empty($email)) $erroremail = true;
        if (empty($address)) $erroraddress = true;
        if (empty($pass)) $errorpass = true;
        if (empty($cpass)) $errorcpass = true;

        $errorEmpty = true;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Invalid email address!</strong><br> You should write a valid email address.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
        $errorEmail = true;
    } else if (!is_numeric($contact) || strlen($contact) != 11) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Invalid Contact Number!</strong><br> Please make sure you entered a valid contact number.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
        $errorContact = true;
    } else if (usernameexists($conn, $uname)) {
        $userExist = true;
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Username Already Exists!</strong><br> Please write another username.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    } else if (emailexists($conn, $email)) {
        $errorEmail = true;
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Email Already Exists!</strong><br> Please enter another email.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    } else if ($pass != $cpass) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Password Mismatch!</strong><br> Please make sure that you entered the same password.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
        $errorCpass = true;
    } else if (!preg_match('/[A-Z]/', $pass) || !preg_match('/[a-z]/', $pass) || !preg_match('/\d/', $pass) || !preg_match('/[\W_]/', $pass)) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Weak Password!</strong><br> Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
        $errorPass = true;
    } else {
        $otp = register($fname, $mname, $lname, $address, $gender, $contact, $bday, $uname, $pass, $email, $conn);
        if ($otp !== false) {
            if (sendConfirmationEmail($email, $otp)) {
                echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'User registered successfully! An OTP has been sent to your email.',
                    icon: 'success',
                    confirmButtonColor: '#d9534f',
                }); 
                let button = document.querySelectorAll('.swal2-confirm').forEach(a => a.onclick = function () {
                    window.location.href = 'verify.php';
                });
                </script>";
            } else {
                echo "User registered successfully! However, the OTP email could not be sent.";
            }
        } else {
            echo "Registration failed.";
        }
    }
}
?>

<script>
    $("#fname,#lname,#bday,#email,#contact,#address,#pass,#cpass").removeClass("is-invalid");
    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorContact = "<?php echo $errorContact; ?>";
    var errorPass = "<?php echo $errorPass; ?>";
    var errorfname = "<?php echo $errorfname; ?>";
    var errorlname = "<?php echo $errorlname; ?>";
    var errorbday = "<?php echo $errorbday; ?>";
    var erroremail = "<?php echo $erroremail; ?>";
    var erroraddress = "<?php echo $erroraddress; ?>";
    var errorcontact = "<?php echo $errorcontact; ?>";
    var errorpass = "<?php echo $errorpass; ?>";
    var errorcpass = "<?php echo $errorcpass; ?>";
    var errorCpass = "<?php echo $errorCpass; ?>";

    if (errorEmpty) {
        if (errorfname) $("#fname").addClass("is-invalid");
        if (errorlname) $("#lname").addClass("is-invalid");
        if (errorbday) $("#bday").addClass("is-invalid");
        if (erroremail) $("#email").addClass("is-invalid");
        if (erroraddress) $("#address").addClass("is-invalid");
        if (errorcontact) $("#contact").addClass("is-invalid");
        if (errorpass) $("#pass").addClass("is-invalid");
        if (errorcpass) $("#cpass").addClass("is-invalid");
    }

    if (errorEmail) $("#email").addClass("is-invalid");
    if (errorCpass) $("#cpass").addClass("is-invalid");
    if (errorPass) $("#pass").addClass("is-invalid");
    if (errorContact) $("#contact").addClass("is-invalid");
</script>
