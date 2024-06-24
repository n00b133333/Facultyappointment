<?php
include('../../db.php');
include('faculty_functions.php');
require '../../vendor/autoload.php'; // Adjust the path as necessary
$id = $_GET['id'];
$update = " UPDATE appointments set status = 4 WHERE id = $id";

mysqli_query($conn,$update);






mysqli_close($conn);



header("location:../accepted.php?completed=true");
exit();