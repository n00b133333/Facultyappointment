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

function schedules($conn,$faculty_ID){
    $sql = "SELECT *,appointments.status AS ap_status FROM appointments INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID WHERE faculty.faculty_ID = $faculty_ID AND appointments.status = 0";
    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->appointment_name}</td>
            <td>{$row->meeting_room}</td>
             <td>{$row->u_fname} {$row->u_lname}</td>
            <td>".convertdate($row->appointment_date)."</td>
            
            <td>".converttime($row->start_time)."</td>
            <td>".converttime($row->end_time)."</td>

           
         ";

         if($row->ap_status == 0){
            echo"
          <td>
          <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>View</button>
            </td>
            ";
        } else {
            echo"
            <td>
               <a class='btn btn-success btn-sm' href='includes/accept.php?id={$row->id}' >View</a>
                  <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Cancel</button>
              </td>
              ";
        }

        


        
       
            echo "<td class='text-warning fw-bold'>Pending</td>";
     
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
                                <label for='appointmentDate{$row->id}' class='form-label'>Appointee</label>
                                <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->u_fname} {$row->u_lname}' readonly>
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
                             
 <div class='modal-footer'>

 ";
 if($row->ap_status == 0){
    echo"
 

     <a class='btn btn-success ' href='includes/accept.php?id={$row->id}' >Accept</a>
        <button class='btn btn-danger ' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Decline</button>
   
    ";
} else {
    echo"
   
       <a class='btn btn-success ' href='includes/accept.php?id={$row->id}' >View</a>
          <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Cancel</button>
     
      ";
}
 echo "
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                
                            </div>
                      
                    </div>
                </div>
            </div>
        </div>";

echo "
      <!-- Delete Modal -->
      <div class='modal fade' id='deleteModal{$row->id}' tabindex='-1' aria-labelledby='deleteModal{$row->id}Label' aria-hidden='true'>
          <div class='modal-dialog'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='deleteModal{$row->id}Label'>Decline Appointment</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                      <form action='includes/decline_appointment.php?id={$row->id}' method='post'>
                          <input type='hidden' name='id{$row->id}' value='{$row->id}'>
                          <p>Please state your reason for declining this appointment</p>
                          <div class='form-floating'>
  <textarea class='form-control mb-3' name='reason{$row->id}' placeholder='Leave a comment here' id='reason{$row->id}'></textarea>
  <label for='reason{$row->id}'>Type here</label>
</div>
                          <div class='modal-footer'>
                          
                               <button type='button' class='btn btn-secondary' data-bs-toggle='modal'  data-bs-target='#updateModal{$row->id}'>Close</button>
                              <button type='submit' name='submit{$row->id}' class='btn btn-danger'>Decline</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>";
  }
}

function acschedules($conn,$faculty_ID){
    $sql = "SELECT *,appointments.status AS ap_status FROM appointments LEFT JOIN declined_appointments ON appointments.id = declined_appointments.appointment_ID  INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID WHERE faculty.faculty_ID = $faculty_ID AND appointments.status IN (1,2,4) ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->appointment_name}</td>
            <td>{$row->notes}</td>
             <td>{$row->u_fname} {$row->u_lname}</td>
            <td>".convertdate($row->appointment_date)."</td>
            
            <td>".converttime($row->start_time)."</td>
            <td>".converttime($row->end_time)."</td>

           
         ";

   
            echo"
           <td>
          
                  <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>View</button>
              </td>
              ";
      

        


        
        if($row->ap_status == 1){
            echo "<td class='text-success fw-bold' >Approved</td>";
        } else if($row->ap_status == 2) {
            echo "<td class='text-danger fw-bold'>Canceled</td>";
        }
        else{
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
                                <label for='appointmentDate{$row->id}' class='form-label'>Description</label>
                                <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->notes}' readonly>
                            </div>
                                <div class='form-group  mb-3'>
                                <label for='appointmentDate{$row->id}' class='form-label'>Appointee</label>
                                <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->u_fname} {$row->u_lname}' readonly>
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


if($row->ap_status == 2){
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
                     
                    </div>
                </div>
            </div>
        </div>";
}
else if($row->ap_status == 1){
    echo"   <div class='modal-footer'>
    <a href='includes/completed.php?id={$row->id}' class='btn btn-primary'>Done</a>
         <button class='btn btn-danger ' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Cancel appointment</button>
    <button type='button' class='btn btn-secondary'  data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>Close</button>
    
</div>
</form>
</div>
</div>
</div>
</div>";
}
else{
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
  <textarea class='form-control mb-3' name='reason{$row->id}' placeholder='Leave a comment here' id='reason{$row->id}'></textarea>
  <label for='reason{$row->id}'>Type here</label>
</div>
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                              <button type='submit' name='submit{$row->id}' class='btn btn-danger'>Cancel appointment</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>";
  }
}


function decschedules($conn,$faculty_ID){
    $sql = "SELECT *,appointments.status AS ap_status FROM appointments INNER JOIN declined_appointments ON appointments.id = declined_appointments.appointment_ID  INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID WHERE faculty.faculty_ID = $faculty_ID AND appointments.status = 1 OR appointments.status = 3";
    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->appointment_name}</td>
            <td>{$row->notes}</td>
             <td>{$row->u_fname} {$row->u_lname}</td>
            <td>".convertdate($row->appointment_date)."</td>
            
            <td>".converttime($row->start_time)."</td>
            <td>".converttime($row->end_time)."</td>

           
         ";

         
            echo"
            <td>
          
                  <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>View</button>
              </td>
              ";
       

        


        
   
            echo "<td class='text-danger fw-bold'>Declined</td>";
      

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
                      <form action='includes/update_appointment.php' method='post'>
                          <input type='hidden' name='id' value='{$row->id}'>
                          <div class='form-group  mb-3'>
                              <label for='appointmentName{$row->id}' class='form-label'>Appointment Name</label>
                              <input type='text' class='form-control' id='appointmentName{$row->id}' name='appointmentName' value='{$row->appointment_name}' readonly>
                          </div>
                          <div class='form-group  mb-3'>
                              <label for='appointmentDate{$row->id}' class='form-label'>Description</label>
                              <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->notes}' readonly>
                          </div>
                              <div class='form-group  mb-3'>
                              <label for='appointmentDate{$row->id}' class='form-label'>Appointee</label>
                              <input type='text' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->u_fname} {$row->u_lname}' readonly>
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
                            <div class='form-group  mb-3'>
                              <label for='endTime{$row->id}' class='form-label'>Reason for declining appointment</label>
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
      </div>

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
  <textarea class='form-control mb-3' name='reason{$row->id}' placeholder='Leave a comment here' id='reason{$row->id}'></textarea>
  <label for='reason{$row->id}'>Type here</label>
</div>
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                              <button type='submit' name='submit{$row->id}' class='btn btn-danger'>Cancel appointment</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>";
  }
}
function manageSchedules($conn) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = intval($_POST['id']);
        $action = $_POST['action'];

        if ($action == 'approve') {
            $sql = "UPDATE appointments SET status = 1 WHERE id = $id";
        } elseif ($action == 'decline') {
            $sql = "UPDATE appointments SET status = 2 WHERE id = $id";
        }

        if (mysqli_query($conn, $sql)) {
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to the same page
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Display the schedule
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
                <form action='' method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row->id}'>
                    <input type='hidden' name='action' value='approve'>
                    <button type='submit' class='btn btn-success btn-sm'>Approve</button>
                </form>
                <form action='' method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row->id}'>
                    <input type='hidden' name='action' value='decline'>
                    <button type='submit' class='btn btn-danger btn-sm'>Decline</button>
                </form>
            </td>
            <td>";
        
        if ($row->status == 0) {
            echo "Pending";
        } elseif ($row->status == 1) {
            echo "Approved";
        } else {
            echo "Declined";
        }

        echo "</td>
        </tr>";
    }
}

function login($uname, $pass, $conn)
{
    $sql = "SELECT * FROM faculty WHERE email = ? AND pass = ?";
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



function otppass($email, $conn) {

    $query = "SELECT * FROM faculty WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return false; // Username already exists
    }
    

    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    $query = "UPDATE faculty SET reset_otp = ? WHERE email = ?";
   
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $otp,$email);
    
    if ($stmt->execute()) {
        return $otp;
    } else {
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



function notifEmail($email,$name) {
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
        $mail->Body    = "
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
                color: #5cb85c; /* Bootstrap success color */
            }
            .content {
                margin-bottom: 20px;
            }
            .footer {
                font-size: 0.9em;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>Appointment Schedule Approved</div>
            <div class='content'>
                Faculty member <strong>{$name}</strong> has approved your appointment schedule.
            </div>
            <div class='footer'>
                If you have any questions, please contact the faculty member directly.
            </div>
        </div>
    </body>
    </html>
    ";
        $mail->AltBody = "
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
                color: #5cb85c; /* Bootstrap success color */
            }
            .content {
                margin-bottom: 20px;
            }
            .footer {
                font-size: 0.9em;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>Appointment Schedule Approved</div>
            <div class='content'>
                Faculty member <strong>{$name}</strong> has approved your appointment schedule.
            </div>
            <div class='footer'>
                If you have any questions, please contact the faculty member directly.
            </div>
        </div>
    </body>
    </html>
    ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}



function declinedEmail($email,$name,$reason) {
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
                Faculty member <strong>{$name}</strong> has canceled your appointment schedule.
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



function verifypassOTP($email, $otp, $conn) {
    $query = "SELECT * FROM faculty WHERE email = ? AND reset_otp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is correct, clear OTP field
        $query = "UPDATE faculty SET reset_otp = NULL WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return true;
    } else {
        return false;
    }
}

function usernameexists($conn, $email){
    $sql="SELECT * FROM faculty WHERE email = '$email'";
    
            $resultData = mysqli_query($conn,$sql);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
    }

    
function userinfo($conn, $id){
    $sql="SELECT * FROM faculty WHERE faculty_ID = '$id'";
    
            $resultData = mysqli_query($conn,$sql);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $results = false;
            return $results;
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
    
    


        