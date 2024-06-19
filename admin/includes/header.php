<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
   
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<?php include '../db.php'; ?>
<?php include 'includes/admin_functions.php'?>

</head>
<body class="fixed-nav sticky-footer bg-light" id="page-top">

<?php 
session_start();

if(isset($_GET['archived'])){
    echo "
     <script> 
     
     Swal.fire({
         title: 'Archived!',
         text: 'Account archived successfully!',
         icon: 'success',
         confirmButtonColor: '#d9534f',
     
       }); 
       
     
       
       </script>
    ";
}

?>
