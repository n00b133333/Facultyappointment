<?php

include "../../db.php";
include "admin_functions.php";

$id = $_GET['id'];
$sql = "UPDATE  users SET archive = 0 WHERE user_ID = $id";
mysqli_query($conn,$sql);
mysqli_close($conn);
header("location:../archived_users.php?unarchived=true");