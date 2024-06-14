<?php
$page = "Users";
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add user</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php include 'add_user.php' ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<table id="myTable" class="display col ">

    <thead>
        <tr>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Username</th>
            <th>Action</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php userTable($conn) ?>
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