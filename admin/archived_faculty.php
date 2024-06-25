
<?php
  $page='Archives'; 
 include "includes/header.php"; ?>
 <?php include('includes/sidenavbar.php'); ?>
 
<script>
    $(document).ready( function () {
    $('#myTable').DataTable({
        /* No ordering applied by DataTables during initialisation */
        "order": []
    });
 
} );

</script>
<script>
  $(document).ready(function () {
    
    $("form").submit(function (event) {
      event.preventDefault();

      var formData = new FormData();
      formData.append("id", <?php echo $_SESSION['admin_ID'] ?>);
      formData.append("fname", $("#fname").val());
      formData.append("lname", $("#lname").val());
      formData.append("midname", $("#midname").val());
      formData.append("pic", $("#pic")[0].files[0]);
 
      formData.append("email", $("#email").val());
      formData.append("uname", $("#uname").val());
     
    
      formData.append("pass", $("#pass").val());
      formData.append("cpass", $("#cpass").val());
      formData.append("submit", $("#submit").val());

      $.ajax({
        url: "includes/update_profile.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $(".form-message").html(response);
        },
        error: function (error) {
          console.log("Error: " + error);
        },
      });
    });
  });
</script>



  <div class="right-content">
    <h3 class="m-4 "> <a href="archives.php" class="text-decoration-none  btn btn-sm btn-dark"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
</svg>
</a>  Archives / Faculty Accounts</h3>


    
    <div class="table-container m-4">


    <div class="row text-center mt-3 glass bg-white rounded shadow-lg">
    <div class="col bg-dark rounded p-4 mb-3">

</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add user</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="form-message"></div>
      <form action="" method="post">
      <div class="modal-body">
        <?php include 'add_user.php' ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="submit" class="btn btn-primary">Add user</button>
      </div>
      </form>
    
    </div>
  </div>
</div>
<table id="myTable" class="display col ">

    <thead>
        <tr>
            <th  class="res">Profile</th>
            <th>Name</th>
            <th  class="res">Email</th>
            <th  class="res">Address</th>
            <th>Contact Number</th>
          
            <th>Action</th>
         
        </tr>
    </thead>
    <tbody>
    <?php archivedFacultyTable($conn) ?>
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



  
  </div>
 
</div>


    </div>

    <div class="form-message"></div>
    </div>

</main>

<!--Start-->




<!--End-->


<script>
  let new_picture = document.getElementById("pic");
  const imagePreview = document.getElementById("image_preview");

  new_picture.onchange = function(){
    imagePreview.src = URL.createObjectURL(new_picture.files[0]);
  }
</script>
</body>
</html>