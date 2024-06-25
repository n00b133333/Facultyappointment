<?php
$page = "Archives";
include('includes/header.php'); ?>

<?php require_once('../db.php') ?>

    <style>
      

        #sidenavbar {
            width: 250px;
            background-color: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #main-content {
            margin-left: 10px;
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .container.py-5 {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }

        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
        .card:hover{
            transform: scale(1.1);
            transition-duration: .5s;
        }
    </style>
</head>
 
<body class="bg-light">
    <div id="page-container">
        <?php include('includes/sidenavbar.php'); ?>
        <div id="main-content">
            <div class="container py-5">
                <div class="row justify-content-center gap-5">
                   
                <div class="card shadow-lg p-2"  style="width: 18rem;">
                <a href="archived_users.php"  class="nav-link">
  <img src="../img/logo.png" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text text-center fw-bold fs-3 ">User Accounts</p>
  </div>
  </a>

</div>


<div class="card shadow-lg p-2"  style="width: 18rem;">
<a href="archived_faculty.php" class="nav-link">
  <img src="../img/logo.png" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text text-center fw-bold fs-3 ">Faculty Accounts</p>
  </div>
  </a>
</div>
   
                </div>
            </div>
           

        </div>
  
</body>

 
</html>

<?php include('includes/footer.php'); ?>
