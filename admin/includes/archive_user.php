<?php

include "../../db.php";
include "admin_functions.php";

$id = $_GET['id'];
$sql = "UPDATE  users SET archive = 1 WHERE user_ID = $id";
mysqli_query($conn,$sql);
mysqli_close($conn);
header("location:../users.php?archived=true");