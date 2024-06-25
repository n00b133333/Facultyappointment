<?php
$page = "Dashboard";
include('includes/header.php'); ?>
<style>
  body{
    padding-right: 0px!important;
  }
</style>
<?php include('includes/sidenavbar.php'); ?>


<div class="row gap-3 mb-3 ">
<div class="card col-md col-sm-12" >
  <div class="card-body">
    <h5 class="card-title">Total Appointments</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text d-flex justify-content-between"><svg  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
</svg> <span class="fw-bold fs-2"><?php echo  totalapp($conn)->count; ?></span>
</p>
    <!-- <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a> -->
  </div>
</div>

<div class="card col-md col-sm-12" >
  <div class="card-body">
    <h5 class="card-title">Approved Appointments</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text d-flex justify-content-between"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg><span class="fw-bold fs-2"><?php echo  totalcompleted($conn)->count; ?></span>


</p>

  </div>
</div>


<div class="card col-md col-sm-12" >
  <div class="card-body">
    <h5 class="card-title">Total Users</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text d-flex justify-content-between">
    
    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
</svg><span class="fw-bold fs-2"><?php echo  totalusers($conn)->count; ?></span>


  
</p>
    <!-- <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a> -->
  </div>
</div>


<div class="card col-md col-sm-12" >
  <div class="card-body">
    <h5 class="card-title">Total Faculty Members</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
    <p class="card-text d-flex justify-content-between">  <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
</svg><span class="fw-bold fs-2"><?php echo  totalfaculty($conn)->count; ?></span>

</p>
    <!-- <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a> -->
  </div>



</div>

</div>

<div class="row gap-3 mb-3">


<div class="card col-12 p-0" >
  <div class="bg-dark rounded p-2 w-100 text-light text-center fw-bold">Appointments per Faculty Members</div>
  <div class="card-body">
  <canvas id="myChart" style="max-height: 400px!important;"></canvas>
  </div>
</div>


<div class="card col-12 p-0" >
<div class="bg-dark rounded p-2 w-100 text-light text-center fw-bold">Appointment Statuses</div>
  <div class="card-body">
  <canvas id="myChart2" style="max-height: 400px!important;"></canvas>
  </div>
</div>






<!-- <?php 
            $sql = "SELECT *,appointments.status AS ap_status FROM appointments LEFT JOIN declined_appointments ON appointments.id = declined_appointments.appointment_ID  INNER JOIN faculty ON appointments.faculty_ID = faculty.faculty_ID INNER JOIN users ON appointments.user_ID = users.user_ID ORDER BY created_at DESC";
            $result = mysqli_query($conn, $sql);
          
            while($row = mysqli_fetch_object($result)){
             echo "'".$row->fname."', ";
            }

          ?> -->


<?php include('includes/footer.php'); ?>
<script>
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php 
            $sql = "SELECT * FROM faculty where archive != 1";
            $result = mysqli_query($conn, $sql);
          
            while($row = mysqli_fetch_object($result)){
             echo "'".$row->fname."', ";
            }

          ?>

      ],
      datasets: [{
        label: 'Number of appointments',
        data: [    <?php 
            $sql = "SELECT * FROM faculty where archive != 1";
            $result = mysqli_query($conn, $sql);
          
            while($row = mysqli_fetch_object($result)){
             echo facultyid($conn, $row->faculty_ID)->count.", ";
            }

          ?>],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


  new Chart(ctx2, {
    type: 'pie',
    data : {
  labels: [
    'Pending',
    'Approved',
    'Declined',
    'Canceled',
    'Completed',
  ],
  datasets: [{
    label: 'Number of appointments',
    data: [
      <?php
       echo countap($conn, 0)->count
      ?>,
        <?php
       echo countap($conn, 1)->count
      ?>,
        <?php
       echo countap($conn, 2)->count
      ?>,
        <?php
       echo countap($conn, 3)->count
      ?>,
        <?php
       echo countap($conn, 4)->count
      ?>,
    ],
    backgroundColor: [
      'rgb(254, 205, 86)',
      '#157F1F',
      '#c1121f',
      '#531253',
      '#6FFFE9',
    ],
    hoverOffset: 4
  }]
},
 
  });
</script>