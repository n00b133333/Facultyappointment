<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function schedules($conn){
    $sql = "SELECT * FROM appointments";
    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->appointment_name}</td>
            <td>{$row->appointment_date}</td>
            <td>{$row->start_time}</td>
            <td>{$row->end_time}</td>

            <td>
                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>Edit</button>
                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Delete</button>
            </td>
            <td>";
        
        if($row->status == 0){
            echo "Pending";
        } else {
            echo "Completed";
        }

        echo "</td>
  
        <!-- Update Modal -->
        <div class='modal fade' id='updateModal{$row->id}' tabindex='-1' aria-labelledby='updateModal{$row->id}Label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='updateModal{$row->id}Label'>Update Appointment</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form action='includes/update_appointment.php' method='post'>
                            <input type='hidden' name='id' value='{$row->id}'>
                            <div class='form-group'>
                                <label for='appointmentName{$row->id}' class='form-label'>Appointment Name</label>
                                <input type='text' class='form-control' id='appointmentName{$row->id}' name='appointmentName' value='{$row->appointment_name}' required>
                            </div>
                            <div class='form-group'>
                                <label for='appointmentDate{$row->id}' class='form-label'>Date</label>
                                <input type='date' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->appointment_date}' required>
                            </div>
                            <div class='form-group'>
                                <label for='startTime{$row->id}' class='form-label'>Start Time</label>
                                <input type='time' class='form-control' id='startTime{$row->id}' name='startTime' value='{$row->start_time}' required>
                            </div>
                            <div class='form-group'>
                                <label for='endTime{$row->id}' class='form-label'>End Time</label>
                                <input type='time' class='form-control' id='endTime{$row->id}' name='endTime' value='{$row->end_time}' required>
                            </div>
                                                        <div class='form-group'>
                                <label for='status{$row->id}' class='form-label'>End Time</label>
                                <input type='time' class='form-control' id='status{$row->id}' name='status' value='{$row->status}' required>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-primary'>Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  
        <!-- Delete Modal -->
        <div class='modal fade' id='deleteModal{$row->id}' tabindex='-1' aria-labelledby='deleteModal{$row->id}Label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='deleteModal{$row->id}Label'>Delete Appointment</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form action='includes/delete_appointment.php' method='post'>
                            <input type='hidden' name='id' value='{$row->id}'>
                            <p>Are you sure you want to delete this appointment?</p>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-danger'>Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
    }
  }

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
