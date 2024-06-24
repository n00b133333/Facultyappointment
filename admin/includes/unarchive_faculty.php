<?php

include "../../db.php";
include "admin_functions.php";

$id = $_GET['id'];
$sql = "UPDATE  faculty SET archive = 0 WHERE faculty_ID = $id";
mysqli_query($conn,$sql);
mysqli_close($conn);
header("location:../archived_faculty.php?unarchived=true");