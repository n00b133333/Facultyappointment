<?php
$page = "Dashboard";
include('includes/header.php'); ?>

<?php require_once('../db.php') ?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../fullcalendar/lib/main.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../fullcalendar/lib/main.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: 'Noto Sans';
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
        }

        #page-container {
            display: flex;
            height: 100%;
            width: 100%;
        }

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
    </style>
</head>
 
<body class="bg-light">
    <div id="page-container">
        <?php include('includes/sidenavbar.php'); ?>
        <div id="main-content">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-9" >
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <!-- Event Details Modal -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header rounded-0">
                            <h5 class="modal-title">Schedule Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body rounded-0">
                            <div class="container-fluid">
                                <dl>
                                    <dt class="text-muted">Title</dt>
                                    <dd id="title" class="fw-bold fs-4"></dd>
                                    <dt class="text-muted">Description</dt>
                                    <dd id="description" class=""></dd>
                                    <dt class="text-muted">Start</dt>
                                    <dd id="start" class=""></dd>
                                    <dt class="text-muted">End</dt>
                                    <dd id="end" class=""></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="modal-footer rounded-0">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Event Details Modal -->
        </div>
    </div>
 
<?php 
$appointments = $conn->query("SELECT * FROM `appointments`");
$app_res = [];
foreach($appointments->fetch_all(MYSQLI_ASSOC) as $row){
    $start_datetime = $row['appointment_date'] . ' ' . $row['start_time'];
    $end_datetime = $row['appointment_date'] . ' ' . $row['end_time'];
    $row['sdate'] = date("F d, Y h:i A",strtotime($start_datetime));
    $row['edate'] = date("F d, Y h:i A",strtotime($end_datetime));
    $row['start_datetime'] = $start_datetime;
    $row['end_datetime'] = $end_datetime;
    $app_res[$row['id']] = $row;
}
?>
<?php 
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($app_res) ?>')
</script>
<script src="../js/script.js"></script>
 
</html>

<?php include('includes/footer.php'); ?>
