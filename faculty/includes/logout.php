<?php
session_start();
unset($_SESSION['faculty_ID']);
unset($_SESSION['faculty_email']);
unset($_SESSION['faculty_fname']);
unset($_SESSION['faculty_mname']);
unset($_SESSION['faculty_lname']);




header("location:../index.php");
exit();