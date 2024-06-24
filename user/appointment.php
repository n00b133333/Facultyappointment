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
  <div class="col p-3 bg-dark rounded mb-3">
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
    <svg class="w-6 h-6 text-gray-800 dark:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path fill="currentColor" d="M4 9.05H3v2h1v-2Zm16 2h1v-2h-1v2ZM10 14a1 1 0 1 0 0 2v-2Zm4 2a1 1 0 1 0 0-2v2Zm-3 1a1 1 0 1 0 2 0h-2Zm2-4a1 1 0 1 0-2 0h2Zm-2-5.95a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-7 3a1 1 0 0 0 2 0H6Zm2-3a1 1 0 1 0-2 0h2Zm8 3a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-13 3h14v-2H5v2Zm14 0v12h2v-12h-2Zm0 12H5v2h14v-2Zm-14 0v-12H3v12h2Zm0 0H3a2 2 0 0 0 2 2v-2Zm14 0v2a2 2 0 0 0 2-2h-2Zm0-12h2a2 2 0 0 0-2-2v2Zm-14-2a2 2 0 0 0-2 2h2v-2Zm-1 6h16v-2H4v2ZM10 16h4v-2h-4v2Zm3 1v-4h-2v4h2Zm0-9.95v-3h-2v3h2Zm-5 0v-3H6v3h2Zm10 0v-3h-2v3h2Z"/>
</svg>

      Add Appointment
    </button>
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
            <label for="room" class="form-label">Room</label>
            <select class="form-select" aria-label="Default select example"  id="room" name="room">

<option value="Office">Office</option>

</select>
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
          <button type="submit" id="submit" class="btn btn-danger">Add Appointment</button>
        </div>
      </form>
    </div>
  </div>
</div>


  <table id="myTable" class="display col">
    <thead>
      <tr>
        <th>Appointment Title</th>
        <th>Meeting Room</th>
        <th>Faculty Member</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
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
    }
  });

  const myModal = document.getElementById('myModal');
  const myInput = document.getElementById('myInput');

  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus();
  });
</script>

<?php include('includes/footer.php'); ?>
