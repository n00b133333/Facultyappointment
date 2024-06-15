<?php
include("../db.php");

function schedules($conn){
    $sql = "SELECT * FROM schedule_list";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_object($result)){
        echo "
        <tr>
            <td>{$row->title}</td>
            <td>{$row->description}</td>
            <td>{$row->start_datetime}</td>
            <td>{$row->end_datetime}</td>
        </tr>

        <!-- Update Modal -->
        <div class='modal fade' id='updateModal{$row->id}' tabindex='-1' aria-labelledby='updateModal{$row->id}Label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='updateModal{$row->id}Label'>Update Schedule</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form action='includes/update_schedule.php' method='post'>
                            <input type='hidden' name='id' value='{$row->id}'>
                            <div class='mb-3'>
                                <label for='title' class='form-label'>Title</label>
                                <input type='text' class='form-control' id='title' name='title' value='{$row->title}' required>
                            </div>
                            <div class='mb-3'>
                                <label for='description' class='form-label'>Description</label>
                                <textarea class='form-control' id='description' name='description' rows='3' required>{$row->description}</textarea>
                            </div>
                            <div class='mb-3'>
                                <label for='start_datetime' class='form-label'>Start</label>
                                <input type='datetime-local' class='form-control' id='start_datetime' name='start_datetime' value='{$row->start_datetime}' required>
                            </div>
                            <div class='mb-3'>
                                <label for='end_datetime' class='form-label'>End</label>
                                <input type='datetime-local' class='form-control' id='end_datetime' name='end_datetime' value='{$row->end_datetime}' required>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-primary'>Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
    }
}
?>
