<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function login($uname, $pass, $conn)
{
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
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

function register($username, $password, $email, $conn) {
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return false; // Username already exists
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    $query = "INSERT INTO admin (adminusername, password, adminemail, otp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $hashed_password, $email, $otp);
    
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
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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

function verifyOTP($username, $otp, $conn) {
    $query = "SELECT * FROM admin WHERE adminusername = ? AND otp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $username, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is correct, clear OTP field
        $query = "UPDATE admin SET otp = NULL WHERE adminusername = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return true;
    } else {
        return false;
    }
}



function userTable($conn){

    $sql = "SELECT * FROM users INNER JOIN status on users.status = status.status_id WHERE archive != 1";

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_object($result)){
        $color='';
        $svg='';
        if($row->status == 0){
            $colorClass = "class='text-danger'";
            $svg = "<svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
  <path stroke='currentColor' stroke-linecap='round' stroke-width='2' d='m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'/>
</svg>
";
        }

        elseif ($row->status == 1){
            $colorClass = "class='text-success'";
            $svg = "<svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
  <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z'/>
</svg>

";

        }

        $male = '';
        $female = '';

      if(  edituserprofile($conn,$row->user_ID)->gender =='Male' ) {
          $male = 'selected';
      }
      elseif(  edituserprofile($conn,$row->user_ID)->gender =='Female'){
        $female = 'selected';
      }


        echo"
       
       <tr >
        <td class='text-center res'><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->u_fname." ".$row->u_lname."</td>
        <td class='res'>".$row->u_email."</td>
        <td class='res'>".$row->address."</td>
        <td class='res'>".$row->contact_number."</td>
        <td>".$row->u_username."</td>

        <td ><div class='text-center  d-flex justify-content-evenly gap-2 p-3 h-100'><a href='update_user_form.php?id=".$row->user_ID."' ><button class='btn btn-outline-success btn-sm' >  <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg></button></a>

        <a href='includes/archive_user.php?id=".$row->user_ID."'><button class='btn btn-outline-danger btn-sm'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-archive'><polyline points='21 8 21 21 3 21 3 8'/><rect x='1' y='3' width='22' height='5'/><line x1='10' y1='12' x2='14' y2='12'/></svg> </button></a>
        </div>
        </td>

        <td ".$colorClass .">".$svg.$row->status_name."</td>
    </tr>
        ";

      

   
    }
}




function archivedUserTable($conn){

    $sql = "SELECT * FROM users INNER JOIN status on users.status = status.status_id WHERE archive = 1";

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_object($result)){
        $color='';
        $svg='';
        if($row->status == 0){
            $colorClass = "class='text-danger'";
            $svg = "<svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
  <path stroke='currentColor' stroke-linecap='round' stroke-width='2' d='m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'/>
</svg>
";
        }

        elseif ($row->status == 1){
            $colorClass = "class='text-success'";
            $svg = "<svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
  <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z'/>
</svg>

";

        }

        $male = '';
        $female = '';

      if(  edituserprofile($conn,$row->user_ID)->gender =='Male' ) {
          $male = 'selected';
      }
      elseif(  edituserprofile($conn,$row->user_ID)->gender =='Female'){
        $female = 'selected';
      }


        echo"
        <tr >
        <td class='text-center res'><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->u_fname." ".$row->u_lname."</td>
        <td class='res'>".$row->u_email."</td>
        <td class='res'>".$row->address."</td>
        <td class='res'>".$row->contact_number."</td>
        <td >".$row->u_username."</td>

        <td class='text-center d-flex justify-content-evenly gap-2 p-3'>

        <a href='includes/unarchive_user.php?id=".$row->user_ID."'><button class='btn btn-outline-success btn-sm'><svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
  <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8'/>
</svg>
 </button></a>
        </td>

        <td ".$colorClass .">".$svg.$row->status_name."</td>
    </tr>
        ";

      

   
    }
}



function archivedFacultyTable($conn){

    $sql = "SELECT * FROM faculty WHERE archive = 1";

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_object($result)){
      

        $male = '';
        $female = '';

      if(  editfacultyprofile($conn,$row->faculty_ID)->gender =='Male' ) {
          $male = 'selected';
      }
      elseif(  editfacultyprofile($conn,$row->faculty_ID)->gender =='Female'){
        $female = 'selected';
      }


        echo"
        <tr >
        <td class='text-center res'><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->fname." ".$row->lname."</td>
        <td class='res'>".$row->email."</td>
        <td class='res'>".$row->address."</td>
        <td>".$row->contact_number."</td>
       

        <td class='text-center d-flex justify-content-evenly gap-2 p-3'>

        <a href='includes/unarchive_faculty.php?id=".$row->faculty_ID."'><button class='btn btn-outline-success btn-sm'><svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
  <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8'/>
</svg>
 </button></a>
        </td>

       
    </tr>
        ";

      

   
    }
}








function facultyTable($conn){

    $sql = "SELECT * FROM faculty WHERE archive != 1";

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_object($result)){
      
        $male = '';
        $female = '';

      if(  editfacultyprofile($conn,$row->faculty_ID)->gender =='Male' ) {
          $male = 'selected';
      }
      elseif(  editfacultyprofile($conn,$row->faculty_ID)->gender =='Female'){
        $female = 'selected';
      }


        echo"
        <tr >
        <td class='text-center res'><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->fname." ".$row->lname."</td>
        <td class='res'>".$row->email."</td>
        <td class='res'>".$row->address."</td>
        <td >".$row->contact_number."</td>
    

        <td ><div class='text-center d-flex justify-content-evenly gap-2 p-3'><a href='update_faculty_form.php?id=".$row->faculty_ID."'><button class='btn btn-outline-success' >  <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg></button></a>

        <a href='includes/archive_faculty.php?id=".$row->faculty_ID."'><button class='btn btn-outline-danger'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-archive'><polyline points='21 8 21 21 3 21 3 8'/><rect x='1' y='3' width='22' height='5'/><line x1='10' y1='12' x2='14' y2='12'/></svg> </button></a>
        <div></td>

        
    </tr>
        ";

      

   
    }
}

function addusernameexists($conn, $uname){
    $sql="SELECT * FROM users WHERE u_username = '$uname'  ";
    
            $resultData = mysqli_query($conn,$sql);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
    }

    function addemailexists($conn, $email){
        $sql="SELECT * FROM faculty WHERE email = '$email'  ";
        
                $resultData = mysqli_query($conn,$sql);
        
            if($row = mysqli_fetch_assoc($resultData)){
                return $row;
            }
            else{
                $results = false;
                return $results;
            }
        }
    

    function edituserprofile($conn,$userid){

        $sql = "SELECT * FROM users WHERE user_ID = $userid";
        $select = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_object($select)){
            return $row;
        }

    }

    function editfacultyprofile($conn,$userid){

        $sql = "SELECT * FROM faculty WHERE faculty_ID = $userid";
        $select = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_object($select)){
            return $row;
        }

    }

    function add_user($fname, $mname, $lname, $address, $gender, $contact, $bday, $username, $pass, $email, $conn) {
      $profile = "user.png";
      $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
      $otp = 0;
      $status = 1;
      
      $query = "INSERT INTO users (profile, u_fname, u_mname, u_lname, address, contact_number, gender, bday, u_username, u_pass, u_email, otp, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($query);
      
      if ($stmt === false) {
          die('Prepare failed: ' . htmlspecialchars($conn->error));
      }
      
      $stmt->bind_param("sssssssssssii", $profile, $fname, $mname, $lname, $address, $contact, $gender, $bday, $username, $hashed_password, $email, $otp, $status);
      
      if ($stmt->execute() === false) {
          die('Execute failed: ' . htmlspecialchars($stmt->error));
      }
      
      $stmt->close();
  }


  function add_faculty($fname, $mname, $lname, $address, $gender, $contact, $bday,  $pass, $email, $conn) {
    $profile = "user.png";
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
   
    
    $query = "INSERT INTO faculty (profile, fname, mname, lname, address, contact_number, gender, bday, pass, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("ssssssssss", $profile, $fname, $mname, $lname, $address, $contact, $gender, $bday, $hashed_password, $email);
    
    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
    
    $stmt->close();
}



function usernameexists($conn, $uname){
    $sql="SELECT * FROM admin WHERE username = '$uname'";
    
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
        $sql="SELECT * FROM admin WHERE email = '$email'";
        
                $resultData = mysqli_query($conn,$sql);
        
            if($row = mysqli_fetch_assoc($resultData)){
                return $row;
            }
            else{
                $results = false;
                return $results;
            }
        }
    

        

function adminTable($conn){

    $sql = "SELECT * FROM admin";

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_object($result)){
       

      


        echo"
        <tr >
        <td class='text-center '><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->fname." ".$row->lname."</td>
        <td>".$row->email."</td>
      
       
        <td>".$row->username."</td>

        <td class='text-center d-flex justify-content-evenly gap-2 p-3'><a href='update_user_form.php?id=".$row->admin_ID."'><button class='btn btn-outline-success' >  <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg></button></a>

        <a href='includes/archive_user.php?id=".$row->admin_ID."'><button class='btn btn-outline-danger'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-archive'><polyline points='21 8 21 21 3 21 3 8'/><rect x='1' y='3' width='22' height='5'/><line x1='10' y1='12' x2='14' y2='12'/></svg> </button></a>
        </td>

        
    </tr>
        ";

      

   
    }
}

 
function userinfo($conn, $id){
    $sql = "SELECT * FROM admin WHERE admin_ID = $id";
    $select = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_object($select)){
        return $row;
    }
    }

    function countap($conn, $id){
        $sql = "SELECT *,COUNT(id) AS count FROM appointments WHERE status = $id";
        $select = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_object($select)){
            return $row;
        }
        }


 


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



function schedules($conn){
    $sql = "SELECT *,appointments.status AS ap_status FROM appointments LEFT JOIN declined_appointments ON appointments.id = declined_appointments.appointment_ID  INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
  
    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->appointment_name}</td>
            <td class='res'>{$row->meeting_room}</td>
             <td class='res'>{$row->u_fname} {$row->u_lname}</td>
            <td>".convertdate($row->appointment_date)."</td>
            
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
  <textarea class='form-control mb-3' name='reason{$row->id}' placeholder='Leave a comment here' id='reason{$row->id}'></textarea>
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


function facultyid($conn, $id){
    $sql = "SELECT *,COUNT(id) AS count FROM appointments WHERE faculty_id = $id";
    $select = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_object($select)){
        return $row;
    }
    }


    
function totalapp($conn){
    $sql = "SELECT *,COUNT(id) AS count FROM appointments";
    $select = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_object($select)){
        return $row;
    }
    }

    function totalcompleted($conn){
        $sql = "SELECT *,COUNT(id) AS count FROM appointments WHERE status = 4";
        $select = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_object($select)){
            return $row;
        }
        }

        
    function totalfaculty($conn){
        $sql = "SELECT *,COUNT(faculty_ID) AS count FROM faculty WHERE archive !=1";
        $select = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_object($select)){
            return $row;
        }
        }

        function totalusers($conn){
            $sql = "SELECT *,COUNT(user_ID) AS count FROM users WHERE archive !=1";
            $select = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_object($select)){
                return $row;
            }
            }

