<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



function login($uname, $pass, $conn)
{
    $sql = "SELECT * FROM users WHERE u_username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uname, $pass);
    $stmt->execute();
    $resultData = $stmt->get_result();

    if($row = $resultData->fetch_assoc()){
        return $row;
    } else {
        return false;
    }
}

function register($fname, $mname, $lname, $address,$gender,$contact,$bday, $username, $pass, $email, $conn) {
    $profile = "user.png";
    $query = "SELECT * FROM users WHERE u_username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return false; // Username already exists
    }
    
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    $query = "INSERT INTO users (profile,u_fname,u_mname,u_lname,address,contact_number,gender,bday,u_username, u_pass, u_email, otp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssssi",$profile, $fname, $mname, $lname, $address,$contact,$gender,$bday,$username, $hashed_password, $email, $otp);
    
    if ($stmt->execute()) {
        return $otp;
    } else {
        return false;
    }
}

function otppass($email, $conn) {

    $query = "SELECT * FROM users WHERE u_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return false; // Username already exists
    }
    

    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    $query = "UPDATE users SET reset_otp = ? WHERE u_email = ?";
   
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $otp,$email);
    

    if ($stmt->execute()) {
        return $otp;
    } else {
        return false;
    }
}

function sendConfirmationEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'facultyappointment90@gmail.com';       //SMTP username
        $mail->Password   = 'txwu pozr akhl ytsc';                  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to

        //Recipients
        $mail->setFrom('facultyappointment90@gmail.com', 'Activation Code');
        $mail->addAddress($email);                                  //Add a recipient

        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Registration Confirmation';
        $mail->Body    = "Thank you for registering. Your OTP is: <b>{$otp}</b>";
        $mail->AltBody = "Thank you for registering. Your OTP is: {$otp}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}



function forgotPasswordEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'facultyappointment90@gmail.com';       //SMTP username
        $mail->Password   = 'txwu pozr akhl ytsc';                  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to

        //Recipients
        $mail->setFrom('facultyappointment90@gmail.com', 'Reset Password Code');
        $mail->addAddress($email);                                  //Add a recipient

        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Reset Password';
        $mail->Body    = "Enter this code to reset your password: <b>{$otp}</b>";
        $mail->AltBody = "Enter this code to reset your password: {$otp}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}


function verifyOTP($username, $otp, $conn) {
    $query = "SELECT * FROM users WHERE u_username = ? AND otp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $username, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is correct, clear OTP field
        $query = "UPDATE users SET otp = NULL , status = '1' WHERE u_username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return true;
    } else {
        return false;
    }
}


function verifypassOTP($email, $otp, $conn) {
    $query = "SELECT * FROM users WHERE u_email = ? AND reset_otp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is correct, clear OTP field
        $query = "UPDATE users SET reset_otp = NULL WHERE u_email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return true;
    } else {
        return false;
    }
}



function usernameexists($conn, $uname){
    $sql="SELECT * FROM users WHERE u_username = '$uname'";
    
            $resultData = mysqli_query($conn,$sql);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
    }

    
function emailexists($conn, $email){
    $sql="SELECT * FROM users WHERE u_email = '$email'";
    
            $resultData = mysqli_query($conn,$sql);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
    }


  


    function emptyInputSignup($fname, $lname, $uname, $pass, $repass){
        $results = false;
        if(empty($fname) || empty($lname) || empty($uname) || empty($pass) || empty($repass)){
            $results = true;
        }
        else{
            $results = false;
        }
        return $results;
    }
    

    
        function loginUser($conn, $uname, $pass){
            $userexist = usernameexists($conn, $uname);
        
            if($userexist === false){
                 header("Location:../index.php?error=incorrect_username");
                 exit();
            }
        
                $passhashed = $userexist['password'];
                $checkpwd = password_verify($pass,$passhashed);
                if($checkpwd === false){
                    header("Location:../index.php?error=incorrect_password");
                    exit();
                }
                else if($checkpwd === true){
                    session_start();
                    $_SESSION["userid"] = $userexist['username'];
                    $_SESSION["fname"] = $userexist['fname'];
                    $_SESSION["lname"] = $userexist['lname'];
            
                    header("Location:../student/student_home.php");
                    exit();
            
                }
        }
