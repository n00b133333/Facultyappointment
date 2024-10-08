<?php
session_start();
include "../../db.php";
include "users_functions.php";

if(isset($_POST['submit'])){
   
    $appointmentName = $_POST['appointmentName'];
    $appointmentDate = $_POST['appointmentDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $notes = $_POST['notes'];
    $room = $_POST['room'];
    $faculty = $_POST['faculty'];

    $errorName = false;
    $errorStartTime = false;
    $errorNotes = false;
    $errorDate = false;
    $errorEmpty = false;
    $errorTime = false;
    $errorEndTime = false;
    $errorDate = false;
    $errorfaculty = false;
    $errorRoom = false;

    if (empty($appointmentName) || empty($appointmentDate) || empty($startTime) || empty($endTime) || empty($faculty)|| empty($room)|| empty($notes)) {
        echo "
      
      
       <script> 
        Swal.fire({
            title: 'Please fill in all important details!',
            text: 'Please review the fields for any missing or incorrect information.',
            icon: 'error',
             confirmButtonColor: '#d9534f',
        }); 
      
        </script>";

        if (empty($appointmentName)) {
            $errorName = true;
        }
        if (empty($notes)) {
            $errorNotes = true;
        }

        if (empty($appointmentDate)) {
            $errorDate = true;
        }

        if (empty($startTime)) {
            $errorStartTime = true;
        }

        if (empty($endTime)) {
            $errorEndTime = true;
        }
        if (empty($faculty)) {
            $errorfaculty = true;
        }
        if (empty($room)) {
            $errorRoom = true;
        }
        $errorEmpty = true;
    }else if(checkOverlappedAppointment($conn,$_SESSION["user_ID"],$appointmentDate,$startTime,$endTime) == true){

        echo "  <script> 
        Swal.fire({
            title: 'Invalid time range!',
            text: 'The appointment time overlaps with an existing appointment.',
            icon: 'error',
             confirmButtonColor: '#d9534f',
        }); 
      
        </script>";
        $errorTime = true;

    }
    else if(hasTimePassed($appointmentDate,$startTime)){
        echo "  <script> 
        Swal.fire({
            title: 'Invalid time range!',
            text: 'The start time on the given date has already passed.',
            icon: 'error',
             confirmButtonColor: '#d9534f',
        }); 
      
        </script>";
        $errorTime = true;
    }
    
    
    else if ($startTime >= $endTime) {
       
        echo "  <script> 
        Swal.fire({
            title: 'Invalid time range!',
            text: 'Start time must be before end time.',
            icon: 'error',
             confirmButtonColor: '#d9534f',
        }); 
      
        </script>";
        $errorTime = true;
    } else {
        $uid = $_SESSION['user_ID'];
        $sql = "INSERT INTO appointments (appointment_name,meeting_room, user_ID, appointment_date, start_time, end_time, notes, faculty_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissssi", $appointmentName,$room, $uid, $appointmentDate, $startTime, $endTime, $notes, $faculty);

        if ($stmt->execute()) {
          
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
            <strong>Error!</strong><br> Unable to save appointment. Please try again later.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }

        

        $stmt->close();
        $conn->close();
        echo "
        <script> 
        Swal.fire({
            title: 'Success!',
            text: 'Appointment has been successfully created.',
            icon: 'success',
             confirmButtonColor: '#d9534f',
        }); 
        let button = document.querySelectorAll('.swal2-confirm').forEach(a => a.onclick = function (){
            window.location.href = 'appointment.php'
        });
        </script>";
    }
} else {
    echo "Error";
}
?>
