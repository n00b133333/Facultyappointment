<?php
session_start();
unset($_SESSION['user_ID']);
unset($_SESSION['u_username']);
unset($_SESSION['u_fname']);
unset($_SESSION['u_mname']);
unset($_SESSION['u_lname']);




header("location:../index.php");
exit();