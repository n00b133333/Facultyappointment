<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust the path as necessary

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

    $sql = "SELECT * FROM users INNER JOIN status on users.status = status.status_id";

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
        echo"
        <tr>
        <td>".$row->profile."</td>
        <td>".$row->u_fname." ".$row->u_lname."</td>
        <td>".$row->u_email."</td>
        <td>".$row->address."</td>
        <td>".$row->contact_number."</td>
        <td>".$row->u_username."</td>

        <td class='text-center d-flex justify-content-evenly gap-2 p-3'><button class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#updateModal".$row->user_ID."'>  <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg></button>

        <a href='includes/delete_user.php?id=".$row->user_ID."'><button class='btn btn-outline-danger'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'><polyline points='3 6 5 6 21 6'/><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'/><line x1='10' y1='11' x2='10' y2='17'/><line x1='14' y1='11' x2='14' y2='17'/></svg> </button></a>
        </td>

        <td ".$colorClass .">".$svg.$row->status_name."</td>
    </tr>
        ";

      

        echo '
     

<!-- Modal -->
<div class="modal fade" id="updateModal'.$row->user_ID.'" tabindex="-1" aria-labelledby="updateModal'.$row->user_ID.'Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModal'.$row->user_ID.'Label">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
<form action="includes/sign_up.inc.php" class="text-center" method="post">

<div class="input-group mb-3">
 
  <input type="text" class="form-control" placeholder="First Name" name="fname'.$row->user_ID.'"  id="fname" value="'.edituserprofile($conn,$row->user_ID)->u_fname.'" >

  <input type="text" class="form-control" placeholder="Middle Name" id="mname" value="'.edituserprofile($conn,$row->user_ID)->u_mname.'" >

  <input type="text" class="form-control" placeholder="Last Name" id="lname" value="'.edituserprofile($conn,$row->user_ID)->u_lname.'" >
</div>

<div class="input-group mb-3">
<span class="input-group-text">Birth Date</span>
  <input type="date" class="form-control" placeholder="Birthdate" id="bday" aria-label="Recipient\'s username" aria-describedby="basic-addon2" value="'.edituserprofile($conn,$row->user_ID)->bday.'" >
  
</div>

<div class="input-group mb-3">
<span class="input-group-text">Gender</span>
<select class="form-select" id="gender" aria-label="Default select example">
  <option value="Male">Male</option>
  <option value="Female">Female</option>
</select>

</div>



<div class="input-group mb-3">
  <input type="email" class="form-control" placeholder="Email" id="email" name="email" aria-label="Recipient\'s username" aria-describedby="basic-addon2" value="'.edituserprofile($conn,$row->user_ID)->u_email.'" >

</div>

<div class="input-group mb-3">
  <input type="text" inputmode="numeric" class="form-control" placeholder="Contact No." id="contact" aria-label="Amount (to the nearest dollar)">
</div>

<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Address" id="address" aria-label="Amount (to the nearest dollar)">
</div>

<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Username" id="uname" aria-label="Amount (to the nearest dollar)">
</div>

<div class="input-group mb-3">
  <input type="password" class="form-control" placeholder="Password" id="pass" aria-label="Amount (to the nearest dollar)">
</div>

<div class="input-group mb-3">
  <input type="password" class="form-control" placeholder="Confirm Password" id="cpass" aria-label="Amount (to the nearest dollar)">
</div>

<div>

<!-- <input type="reset" id="submit" name="signup" value="RESET" class="btn btn-danger ms-3 mt-4 p-2 "> -->
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
        ';
    }
}

function addusernameexists($conn, $uname){
    $sql="SELECT * FROM user WHERE username = '$uname'";
    
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

?>
