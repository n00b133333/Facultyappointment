<?php
session_start();
include "../../db.php";
include "admin_functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointmentName = $_POST['appointmentName'];
    $appointmentDate = $_POST['appointmentDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $errorEmpty = false;
    $errorTime = false;
    $errorDate = false;

    if (empty($appointmentName) || empty($appointmentDate) || empty($startTime) || empty($endTime)) {
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

        $errorEmpty = true;
    } else if ($startTime >= $endTime) {
        echo "<div class='alert alert-danger alert-dismissible fade show animate__animated animate__fadeOut' role='alert'>
        <strong>Invalid time range!</strong><br> Start time must be before end time.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
        $errorTime = true;
    } else {
        $sql = "INSERT INTO appointments (appointment_name, appointment_date, start_time, end_time) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $appointmentName, $appointmentDate, $startTime, $endTime);

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
