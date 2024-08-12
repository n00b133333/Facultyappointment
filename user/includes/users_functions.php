<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function converttime($time24) {
    // Convert the 24-hour time format to a timestamp
    $timestamp = strtotime($time24);

    // Format the timestamp into a 12-hour time format with AM/PM
    $time12 = date('g:i A', $timestamp);

    return $time12;
}
function convertdate($date) {
    // Convert the date to a timestamp
    $timestamp = strtotime($date);

    // Format the timestamp into a readable date format
    $readableDate = date('F j, Y', $timestamp);

    return $readableDate;
}
function schedules($conn,$user_ID){
    $sql = "SELECT *,appointments.status AS ap_status FROM appointments LEFT JOIN declined_appointments ON appointments.id = declined_appointments.appointment_ID  INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID WHERE users.user_ID = $user_ID ORDER BY appointments.created_at DESC";
    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->appointment_name}</td>
            <td class='res'>{$row->meeting_room}</td>
             <td class='res'>{$row->fname} {$row->lname}</td>
            <td >".convertdate($row->appointment_date)."</td>
            
            <td class='res'>".converttime($row->start_time)."</td>
            <td class='res'>".converttime($row->end_time)."</td>

           
         ";

   
            echo"
           <td>
          
                  <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>View</button>
              </td>
              ";
        

        


        
        if($row->ap_status == 0){
            echo "<td class='text-warning fw-bold'>Pending</td>";
        } else  if($row->ap_status == 1){
            echo "<td class='text-success fw-bold' >Approved</td>";
        }
        else  if($row->ap_status == 2){
            echo "<td class='text-danger fw-bold'>Canceled</td>";
        }
        else  if($row->ap_status == 3){
            echo "<td class='text-danger fw-bold'>Declined</td>";
        }
        else  if($row->ap_status == 4){
            echo "<td class='text-success fw-bold'>Completed</td>";
        }


        echo"
        <!-- Update Modal -->
        <div class='modal fade' id='updateModal{$row->id}' tabindex='-1' aria-labelledby='updateModal{$row->id}Label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='updateModal{$row->id}Label'>Appointment Details</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                      
                            <input type='hidden' name='id' value='{$row->id}'>
                            <div class='form-group  mb-3'>
                                <label for='appointmentName{$row->id}' class='form-label'>Appointment Name</label>
                                <input type='text' class='form-control' id='appointmentName{$row->id}' name='appointmentName' value='{$row->appointment_name}' readonly>
                            </div>
                              <div class='form-group  mb-3'>
                                <label for='appointmentName{$row->id}' class='form-label'>Meeting Room</label>
                                <input type='text' class='form-control' id='appointmentName{$row->id}' name='appointmentName' value='{$row->meeting_room}' readonly>
                            </div>
                            <div class='form-group  mb-3'>
                                <label for='appointmentDate{$row->id}' class='form-label'>Description</label>
                                <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->notes}' readonly>
                            </div>
                                <div class='form-group  mb-3'>
                                <label for='appointmentDate{$row->id}' class='form-label'>Faculty Member</label>
                                <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->fname} {$row->lname}' readonly>
                            </div>
                            <div class='form-group  mb-3'>
                                <label for='appointmentDate{$row->id}' class='form-label'>Date</label>
                                <input type='date' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->appointment_date}' readonly>
                            </div>
                            <div class='form-group  mb-3'>
                                <label for='startTime{$row->id}' class='form-label'>Start Time</label>
                                <input type='time' class='form-control' id='startTime{$row->id}' name='startTime' value='{$row->start_time}' readonly>
                            </div>
                            <div class='form-group  mb-3'>
                                <label for='endTime{$row->id}' class='form-label'>End Time</label>
                                <input type='time' class='form-control' id='endTime{$row->id}' name='endTime' value='{$row->end_time}' readonly>
                            </div>
                             
";

if($row->ap_status == 1){

    echo " 

<div class='modal-footer'>
    
          
    <button class='btn btn-danger ' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Cancel appointment</button>
        
     <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
</div>

</div>
</div>
</div>
</div>";

}
if($row->ap_status == 2 || $row->ap_status == 3){
    echo " <div class='form-group  mb-3'>
                                <label for='endTime{$row->id}' class='form-label'>
                                ";
                                if($row->canceled_by == 1){
                                    echo"Client's reason for canceling appointment";
                                }
                                else if ($row->canceled_by == 2){
                                    echo"Faculty member's reason for canceling appointment";
                                }
                                else{
                                    echo"Faculty member's reason for declining appointment";
                                }
                                
                                echo "
                                </label>
                                 <div class='form-floating'>
    <textarea class='form-control' placeholder='Leave a comment here' id='floatingTextarea{$row->id}' readonly>{$row->reason}</textarea>
    <label for='floatingTextarea{$row->id}'>Reason</label>
  </div>
                            </div>
                           
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
}
else if($row->ap_status == 0 || $row->ap_status == 4){
    echo"   <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
}


echo "
     <!-- Delete Modal -->
      <div class='modal fade' id='deleteModal{$row->id}' tabindex='-1' aria-labelledby='deleteModal{$row->id}Label' aria-hidden='true'>
          <div class='modal-dialog'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='deleteModal{$row->id}Label'>Cancel Appointment</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                      <form action='includes/cancel_appointment.php?id={$row->id}' method='post'>
                          <input type='hidden' name='id{$row->id}' value='{$row->id}'>
                          <p>Please state your reason for canceling this appointment</p>
                          <div class='form-floating'>
  <textarea class='form-control mb-3' name='reason{$row->id}' placeholder='Leave a comment here' id='reason{$row->id}' required></textarea>
  <label for='reason{$row->id}'>Type here</label>
</div>
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>Close</button>
                              <button type='submit' name='submit{$row->id}' class='btn btn-danger'>Cancel appointment</button>
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


        function userinfo($conn, $id){
            $sql="SELECT * FROM users WHERE user_ID = '$id'";
            
                    $resultData = mysqli_query($conn,$sql);
            
                if($row = mysqli_fetch_assoc($resultData)){
                    return $row;
                }
                else{
                    $results = false;
                    return $results;
                }
            }
        function checkAppointmentDate($conn,$id,$date )
        {

            $sql = "SELECT * FROM users WHERE user_ID = '$id' AND appointment_date = '$date'";

            $resultData = mysqli_query($conn,$sql);

            if($row = mysqli_fetch_assoc($resultData)){
                return $row;
            }
            else{
                $results = false;
                return $results;
            }

        }


        function checkOverlappedAppointment($conn, $id, $date, $start_time, $end_time) {
            $sql = "
                SELECT * FROM appointments 
                WHERE user_ID = '$id' 
                AND appointment_date = '$date' 
                AND (
                    (start_time < '$end_time' AND end_time > '$start_time')
                )
            ";
        
            $resultData = mysqli_query($conn, $sql);
        
            if (mysqli_fetch_assoc($resultData)) {
                // An overlapping appointment exists
                return true;
            } else {
                // No overlapping appointment
                return false;
            }
        }
            function canceledEmail($email,$name,$reason) {
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
                    $mail->setFrom('facultyappointment90@gmail.com', 'TUP - Faculty Appointment Notification');
                    $mail->addAddress($email);                                  //Add a recipient
            
                    //Content
                    $mail->isHTML(true);                                        //Set email format to HTML
                    $mail->Subject = 'Faculty Appointment Notification';
                    $mail->Body    =  "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                        }
                        .container {
                            width: 80%;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            background-color: #f9f9f9;
                        }
                        .header {
                            font-size: 1.2em;
                            margin-bottom: 10px;
                            color: #d9534f; /* Bootstrap danger color */
                        }
                        .content {
                            margin-bottom: 20px;
                        }
                        .reason {
                            font-weight: bold;
                            color: #d9534f; /* Bootstrap danger color */
                        }
                        .footer {
                            font-size: 0.9em;
                            color: #777;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>Appointment Schedule Canceled</div>
                        <div class='content'>
                            User <strong>{$name}</strong> has canceled his/her appointment schedule.
                        </div>
                        <div class='content reason'>
                            Reason for declining the appointment:
                        </div>
                        <div class='content'>
                            {$reason}
                        </div>
                       
                    </div>
                </body>
                </html>
                ";
            ;
                    $mail->AltBody =  "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                        }
                        .container {
                            width: 80%;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            background-color: #f9f9f9;
                        }
                        .header {
                            font-size: 1.2em;
                            margin-bottom: 10px;
                            color: #d9534f; /* Bootstrap danger color */
                        }
                        .content {
                            margin-bottom: 20px;
                        }
                        .reason {
                            font-weight: bold;
                            color: #d9534f; /* Bootstrap danger color */
                        }
                        .footer {
                            font-size: 0.9em;
                            color: #777;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>Appointment Schedule Declined</div>
                        <div class='content'>
                            Faculty member <strong>{$name}</strong> has declined your appointment schedule.
                        </div>
                        <div class='content reason'>
                            Reason for declining the appointment:
                        </div>
                        <div class='content'>
                            {$reason}
                        </div>
                        <div class='footer'>
                            If you have any questions, please contact the faculty member directly.
                        </div>
                    </div>
                </body>
                </html>
                ";
            ;
            
                    $mail->send();
                    return true;
                } catch (Exception $e) {
                    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                    return false;
                }
            }
            

            
    function appointmentinfo($conn, $id){
        $sql=" SELECT * FROM `appointments` INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID WHERE id = $id";
        
                $resultData = mysqli_query($conn,$sql);
        
            if($row = mysqli_fetch_assoc($resultData)){
                return $row;
            }
            else{
                $results = false;
                return $results;
            }
        }
    
        function hasTimePassed($date, $startTime) {
          
            date_default_timezone_set('Asia/Manila');
        
          
            $givenDateTime = strtotime("$date $startTime");
        
            $currentDateTime = time();
        
            return $givenDateTime < $currentDateTime;
        }