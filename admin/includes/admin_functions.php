<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function login($uname, $pass, $conn)
{
    $sql = "SELECT * FROM admin WHERE adminusername = ? AND password = ?";
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
    $query = "SELECT * FROM admin WHERE adminusername = ?";
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
        <td class='text-center '><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->u_fname." ".$row->u_lname."</td>
        <td>".$row->u_email."</td>
        <td>".$row->address."</td>
        <td>".$row->contact_number."</td>
        <td>".$row->u_username."</td>

        <td class='text-center d-flex justify-content-evenly gap-2 p-3'><a href='update_user_form.php?id=".$row->user_ID."'><button class='btn btn-outline-success' >  <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg></button></a>

        <a href='includes/archive_user.php?id=".$row->user_ID."'><button class='btn btn-outline-danger'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-archive'><polyline points='21 8 21 21 3 21 3 8'/><rect x='1' y='3' width='22' height='5'/><line x1='10' y1='12' x2='14' y2='12'/></svg> </button></a>
        </td>

        <td ".$colorClass .">".$svg.$row->status_name."</td>
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
        <td class='text-center '><img src='../uploads/".$row->profile."' alt='' height='50' width='50' style='border-radius:50px;'></td>
        <td>".$row->fname." ".$row->lname."</td>
        <td>".$row->email."</td>
        <td>".$row->address."</td>
        <td>".$row->contact_number."</td>
    

        <td class='text-center d-flex justify-content-evenly gap-2 p-3'><a href='update_faculty_form.php?id=".$row->faculty_ID."'><button class='btn btn-outline-success' >  <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg></button></a>

        <a href='includes/archive_faculty.php?id=".$row->faculty_ID."'><button class='btn btn-outline-danger'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-archive'><polyline points='21 8 21 21 3 21 3 8'/><rect x='1' y='3' width='22' height='5'/><line x1='10' y1='12' x2='14' y2='12'/></svg> </button></a>
        </td>

        
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

  

?>
