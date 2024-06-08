<?php 
include("../../db.php");

function login($uname, $pass)
{
$sql = "SELECT * from admin where 'uname' = $uname AND 'pass' = $pass";
$lsql = mysqli_query($conn,$sql);


}



?>