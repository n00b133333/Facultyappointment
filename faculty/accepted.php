<?php
$page = "Approved Appointments";
include('includes/header.php');
include('includes/sidenavbar.php');
?>

<script>
  $(document).ready(function(){
    $("#addAppointmentForm").submit(function(event){
  event.preventDefault();
  var appointmentName = $("#appointmentName").val();
  var appointmentDate = $("#appointmentDate").val();
  var startTime = $("#startTime").val();
  var endTime = $("#endTime").val();
  var notes = $("#notes").val();
  var faculty= $("#faculty").val();
  var submit = $("#submit").val();

  console.log({
    appointmentName: appointmentName,
    appointmentDate: appointmentDate,
    startTime: startTime,
    endTime: endTime,
    notes: notes,
    faculty: faculty,
    submit: submit
  });

  $(".form-message").load("includes/add_appointment.php", {
    appointmentName: appointmentName,
    appointmentDate: appointmentDate,
    startTime: startTime,
    endTime: endTime,
    notes: notes,
    faculty: faculty,
    submit: submit
  });
});



  });
</script>

<?php 



if(isset($_GET['approved'])){
  echo "
  <script> 

  Swal.fire({
      title: 'Approved!',
      text: 'Appointment successfully approved.',
      icon: 'success',
      confirmButtonColor: '#d9534f',
  
    }); 

    
    </script>";
    
}

if(isset($_GET['completed'])){
  echo "
  <script> 

  Swal.fire({
      title: 'Appointment Completed!',
      text: 'Appointment successfully completed.',
      icon: 'success',
      confirmButtonColor: '#d9534f',
  
    }); 

    
    </script>";
    
}



if(isset($_GET['declined'])){
  echo "
  <script> 

  Swal.fire({
      title: 'Appointment Declined!',
      text: 'Appointment successfully declined.',
      icon: 'success',
      confirmButtonColor: '#d9534f',
  
    }); 

    
    </script>";
    
}

if(isset($_GET['canceled'])){
  echo "
  <script> 

  Swal.fire({
      title: 'Appointment Canceled!',
      text: 'Appointment successfully canceled.',
      icon: 'success',
      confirmButtonColor: '#d9534f',
  
    }); 

    
    </script>";
    
}


?>

<div class="row text-center mt-3 glass bg-white rounded shadow-lg">
  <div class="col p-4 bg-dark rounded mb-3">
    <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
      <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
      </svg>
      Add Appointment
    </button> -->
  </div>

  <!-- Add Appointment Modal -->
<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAppointmentModalLabel">Add Appointment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="form-message"></div>
      <form id="addAppointmentForm" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="appointmentName" class="form-label">Appointment Name</label>
            <input type="text" class="form-control" id="appointmentName" name="appointmentName" required>
          </div>
          <div class="mb-3">
            <label for="appointmentDate" class="form-label">Date</label>
            <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
          </div>
          <div class="mb-3">
            <label for="startTime" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="startTime" name="startTime" required>
          </div>
          <div class="mb-3">
            <label for="endTime" class="form-label">End Time</label>
            <input type="time" class="form-control" id="endTime" name="endTime" required>
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="faculty" class="form-label">Faculty Member</label>
            <select class="form-control" id="faculty" name="faculty" required>
              <?php
              $result = $conn->query("SELECT faculty_ID, fname, lname FROM faculty");
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['faculty_ID']}'>{$row['fname']} {$row['lname']}</option>";
              }
              ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="submit" class="btn btn-primary">Add Appointment</button>
        </div>
      </form>
    </div>
  </div>
</div>


  <table id="myTable" class="display col">
    <thead>
      <tr>
        <th>Appointment Title</th>
        <th class="res">Meeting Room</th>
        <th class="res">Appointee</th>
        <th>Date</th>
        <th class="res">Start Time</th>
        <th class="res">End Time</th>
        <th>Action</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php acschedules($conn,$_SESSION['faculty_ID']) ?>
    </tbody>
  </table>
</div>

<script>
  let table = new DataTable('#myTable', {
    language: {
      "lengthMenu": "<p class='ms-5'>Show _MENU_</p>",
      "search": "Search appointment: ",
      "info": "<p class='ms-5'>Showing _START_ to _END_ of _TOTAL_ appointments</p>",
    }
    ,
    "order": [] // Disable ordering
  });

  const myModal = document.getElementById('myModal');
  const myInput = document.getElementById('myInput');

  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus();
  });
</script>

<?php include('includes/footer.php'); ?>
