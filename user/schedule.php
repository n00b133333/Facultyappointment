<?php
$page = "Schedules";
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
            flex-grow: 0.8;
            padding: 20px;
            overflow-y: auto;
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
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-9  bg-white rounded shadow-lg p-4" >
                        <div id="calendar"></div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="card rounded-0 shadow">
                            <div class="card-header bg-gradient bg-primary text-light">
                                <h5 class="card-title">Schedule Form</h5>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <form action="save_schedule.php" method="post" id="schedule-form">
                                        <input type="hidden" name="id" value="">
                                        <div class="form-group mb-2">
                                            <label for="title" class="control-label">Title</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="start_datetime" class="control-label">Start</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="end_datetime" class="control-label">End</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                    <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- Event Details Modal -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header rounded-0">
                            <h5 class="modal-title">Appointment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body rounded-0">
                            <div class="container-fluid">
                                <dl>
                                    <dt class="text-muted">Title</dt>
                                    <dd id="title" class="fw-bold fs-4"></dd>
                                    <dt class="text-muted">Description</dt>
                                    <dd id="description" class=""></dd>
                                    <dt class="text-muted">Meeting Room</dt>
                                    <dd id="room" class=""></dd>
                                    <dt class="text-muted">Faculty member</dt>
                                    <dd id="faculty" class=""></dd>
                                    <dt class="text-muted">Date of Appointment</dt>
                                    <dd id="start" class=""></dd>
                                    <dt class="text-muted">Time</dt>
                                    <dd id="end" class=""></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="modal-footer rounded-0">
                            <div class="text-end">
                            <!-- <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button> -->
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
    $user_id = $_SESSION['user_ID'];
$schedules = $conn->query("SELECT * FROM `appointments` INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID WHERE users.user_ID = $user_id AND appointments.status = 1");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['title'] = $row['appointment_name'];
    $row['description'] = $row['notes'];
    $row['room'] = $row['meeting_room'];
    $row['adate'] = date("F d, Y ",strtotime($row['appointment_date']));
    $row['sdate'] = date(" h:i A",strtotime($row['start_time']));
    $row['edate'] = date(" h:i A",strtotime($row['end_time']));
    $row['faculty'] = $row['fname']." ".$row['lname'];

    $sched_res[$row['id']] = $row; // Use array_push or [] to append to array instead of using ID as key
}
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = <?php echo json_encode($sched_res, JSON_HEX_TAG); ?>;
    console.log(scheds);
</script>

<script src="../js/script.js"></script>
 
</html>

<?php include('includes/footer.php'); ?>
