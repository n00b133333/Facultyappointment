<?php
include('../../db.php');
include('users_functions.php');
require '../../vendor/autoload.php'; // Adjust the path as necessary
$aid = $_GET['id'];
if(isset($_POST['submit'.$aid])){
    $id = $_POST['id'.$aid];
    $reason_unsanitized = $_POST['reason'.$aid];
    $reason = htmlspecialchars($reason_unsanitized, ENT_QUOTES, 'UTF-8');

    $declined = "INSERT INTO declined_appointments (appointment_id,reason,canceled_by) VALUES ($id,'$reason',1)";

    mysqli_query($conn,$declined);

$update = " UPDATE appointments set status = 2 WHERE id = $id";

mysqli_query($conn,$update);


canceledEmail(appointmentinfo($conn, $id)['email'],appointmentinfo($conn, $id)['u_fname']." ".appointmentinfo($conn, $id)['u_lname'],$reason);


mysqli_close($conn);



header("location:../appointment.php?canceled=true");
exit();
}
else{
    header("location:../appointment.php");
    exit();
}
