<?php
$page = "Appointment";
include('includes/header.php'); ?>

<?php include('includes/sidenavbar.php'); ?>

<div class="row text-center mt-3 glass">
    <div class="col">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>

  Add user
</button>
</div>

<table id="myTable" class="display col ">

    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <!-- <th>Contact Number</th> -->
            <!-- <th>Username</th>
            <th>Action</th>
            <th>Status</th> -->
        </tr>
    </thead>
    <tbody>
    <?php schedules($conn) ?>
    </tbody>
</table>

</div>
</div>
<script>
   let table = new DataTable('#myTable', {
    language:{
           "lengthMenu":     "<p class='ms-5'>Show _MENU_</p>",
           "search":         "Search user: ",
           "info":           "<p class='ms-5'>Showing _START_ to _END_ of _TOTAL_ users</p>",
    }
    
});

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
</script>


<?php include('includes/footer.php'); ?>