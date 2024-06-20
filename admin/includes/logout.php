<?php
session_start();
unset($_SESSION['admin_ID']);
unset($_SESSION['admin_username']);
unset($_SESSION['admin_fname']);
unset($_SESSION['admin_mname']);
unset($_SESSION['admin_lname']);




header("location:../index.php");
exit();