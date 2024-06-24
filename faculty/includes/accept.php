<?php
include('../../db.php');
include('faculty_functions.php');
require '../../vendor/autoload.php'; // Adjust the path as necessary
$id = $_GET['id'];
$update = " UPDATE appointments set status = 1 WHERE id = $id";

mysqli_query($conn,$update);




notifEmail(appointmentinfo($conn, $id)['u_email'],appointmentinfo($conn, $id)['fname']." ".appointmentinfo($conn, $id)['lname']);


mysqli_close($conn);



header("location:../appointments.php?approved=true");
exit();