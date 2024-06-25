<?php
$page = "My Appointments";
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
  var room = $("#room").val();
  var faculty= $("#faculty").val();
  var submit = $("#submit").val();

  console.log({
    appointmentName: appointmentName,
    appointmentDate: appointmentDate,
    startTime: startTime,
    endTime: endTime,
    room: room,
    faculty: faculty,
    submit: submit
  });

  $(".form-message").load("includes/add_appointment.php", {
    appointmentName: appointmentName,
    appointmentDate: appointmentDate,
    startTime: startTime,
    endTime: endTime,
    notes: notes,
    room: room,
    faculty: faculty,
    submit: submit
  });
});



  });
</script>

<div class="row text-center mt-3 glass bg-white rounded shadow-lg">
  <div class="col p-4 bg-dark rounded mb-3">
   
  </div>

  <table id="myTable" class="display col text-center ap-form">
    <thead>
      <tr>
        <th>Appointment Title</th>
        <th class="res">Meeting Room</th>
        <th class="res">Faculty Member</th>
        <th >Date</th>
        <th class="res">Start Time</th>
        <th class="res">End Time</th>
        <th>Action</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php schedules($conn,$_SESSION['user_ID']) ?>
    </tbody>
  </table>
</div>

<script>
  let table = new DataTable('#myTable', {
    language: {
      "lengthMenu": "<p class='ms-5'>Show _MENU_</p>",
      "search": "Search appointment: ",
      "info": "<p class='ms-5'>Showing _START_ to _END_ of _TOTAL_ appointments</p>",
    },
    "order": [] // Disable ordering
  });

  const myModal = document.getElementById('myModal');
  const myInput = document.getElementById('myInput');

  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus();
  });
</script>

<?php include('includes/footer.php'); ?>
