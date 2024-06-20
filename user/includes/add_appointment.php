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
    $faculty = $_POST['faculty'];

    $errorName = false;
    $errorStartTime = false;
    $errorDate = false;
    $errorEmpty = false;
    $errorTime = false;
    $errorEndTime = false;
    $errorDate = false;
    $errorfaculty = false;

    if (empty($appointmentName) || empty($appointmentDate) || empty($startTime) || empty($endTime) || empty($faculty)) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Please fill in all important details!</strong><br> You should check in on some of those fields below.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";

        if (empty($appointmentName)) {
            $errorName = true;
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
        $errorEmpty = true;
    } else if ($startTime >= $endTime) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Invalid time range!</strong><br> Start time must be before end time.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
        $errorTime = true;
    } else {
        $uid = $_SESSION['user_ID'];
        $sql = "INSERT INTO appointments (appointment_name, user_ID, appointment_date, start_time, end_time, notes, faculty_ID) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissssi", $appointmentName, $uid, $appointmentDate, $startTime, $endTime, $notes, $faculty);

        if ($stmt->execute()) {
            echo "
            <script> 
            Swal.fire({
                title: 'Success!',
                text: 'Appointment has been successfully created.',
                icon: 'success',
            }); 
            let button = document.querySelectorAll('.swal2-confirm').forEach(a => a.onclick = function (){
                window.location.href = 'appointments.php'
            });
            </script>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
            <strong>Error!</strong><br> Unable to save appointment. Please try again later.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "Error";
}
?>
