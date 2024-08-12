<?php
$page = "Appointment";
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
  <div class="col p-2 bg-dark rounded mb-3">
   <h3 class="text-light">Schedule Appointment</h3>
  </div>

 
<div class="form-message"></div>
      <form id="addAppointmentForm" method="post" class="p-3">
        <div class="modal-body ap-form text-start " style="min-width: 500px;">
          <div class="row">
          <div class="mb-3 col ">
            <label for="appointmentName" class="form-label">Appointment Name</label>
            <input type="text" class="form-control shadow-sm" id="appointmentName" name="appointmentName" required>
          </div>
        
          <div class="mb-3 col ">
            <label for="room" class="form-label">Room</label>
            <select class="form-select shadow-sm" aria-label="Default select example"  id="room" name="room">

<option value="Office">Office</option>

</select>
          </div>
          </div>
          <div class="mb-3">
            <label for="appointmentDate" class="form-label">Date</label>
            <input type="date" class="form-control shadow-sm" id="appointmentDate" name="appointmentDate" required>
          </div>
          <div class="row">
          <div class="mb-3 col">
            <label for="startTime" class="form-label">Start Time</label>
            <input type="time" class="form-control shadow-sm" id="startTime" name="startTime" required>
          </div>
          <div class="mb-3 col">
            <label for="endTime" class="form-label">End Time</label>
            <input type="time" class="form-control shadow-sm" id="endTime" name="endTime" required>
          </div>
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control shadow-sm" id="notes" name="notes" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="faculty" class="form-label">Faculty Member</label>
            <select class="form-control shadow-sm" id="faculty" name="faculty" required>
              <?php
              $result = $conn->query("SELECT faculty_ID, fname, lname FROM faculty");
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['faculty_ID']}'>{$row['fname']} {$row['lname']}</option>";
              }
              ?>
            </select>
          </div>

        </div>
        <div class=" text-center">
         
          <button type="submit" id="submit" class="btn btn-danger">Add Appointment</button>
        </div>
      </form>
</div>

<script>
  let table = new DataTable('#myTable', {
    language: {
      "lengthMenu": "<p class='ms-5'>Show _MENU_</p>",
      "search": "Search appointment: ",
      "info": "<p class='ms-5'>Showing _START_ to _END_ of _TOTAL_ appointments</p>",
    }
  });

  const myModal = document.getElementById('myModal');
  const myInput = document.getElementById('myInput');

  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus();
  });
</script>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const philippinesTime = new Date(now.getTime() + (8 * 60 * 60 * 1000)); // Adding 8 hours to UTC time
    const today = philippinesTime.toISOString().split('T')[0];
    document.getElementById('appointmentDate').setAttribute('min', today);
});
</script>

<?php include('includes/footer.php'); ?>
