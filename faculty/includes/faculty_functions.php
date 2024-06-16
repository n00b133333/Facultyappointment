<?php
include("../db.php");

function schedules($conn){
  $sql = "SELECT * FROM appointments";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_object($result)){
      echo "
      <tr>
          <td>{$row->appointment_name}</td>
          <td>{$row->date}</td>
          <td>{$row->start_time}</td>
          <td>{$row->end_time}</td>
          <td>
              <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal{$row->id}'>Edit</button>
              <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal{$row->id}'>Delete</button>
          </td>
      </tr>

      <!-- Update Modal -->
      <div class='modal fade' id='updateModal{$row->id}' tabindex='-1' aria-labelledby='updateModal{$row->id}Label' aria-hidden='true'>
          <div class='modal-dialog'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='updateModal{$row->id}Label'>Update Appointment</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                      <form action='includes/update_appointment.php' method='post'>
                          <input type='hidden' name='id' value='{$row->id}'>
                          <div class='form-group'>
                              <label for='appointmentName{$row->id}' class='form-label'>Appointment Name</label>
                              <input type='text' class='form-control' id='appointmentName{$row->id}' name='appointmentName' value='{$row->appointment_name}' required>
                          </div>
                          <div class='form-group'>
                              <label for='appointmentDate{$row->id}' class='form-label'>Date</label>
                              <input type='date' class='form-control' id='appointmentDate{$row->id}' name='appointmentDate' value='{$row->date}' required>
                          </div>
                          <div class='form-group'>
                              <label for='startTime{$row->id}' class='form-label'>Start Time</label>
                              <input type='time' class='form-control' id='startTime{$row->id}' name='startTime' value='{$row->start_time}' required>
                          </div>
                          <div class='form-group'>
                              <label for='endTime{$row->id}' class='form-label'>End Time</label>
                              <input type='time' class='form-control' id='endTime{$row->id}' name='endTime' value='{$row->end_time}' required>
                          </div>
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                              <button type='submit' class='btn btn-primary'>Save changes</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <!-- Delete Modal -->
      <div class='modal fade' id='deleteModal{$row->id}' tabindex='-1' aria-labelledby='deleteModal{$row->id}Label' aria-hidden='true'>
          <div class='modal-dialog'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='deleteModal{$row->id}Label'>Delete Appointment</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                      <form action='includes/delete_appointment.php' method='post'>
                          <input type='hidden' name='id' value='{$row->id}'>
                          <p>Are you sure you want to delete this appointment?</p>
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                              <button type='submit' class='btn btn-danger'>Delete</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>";
  }
}
?>
