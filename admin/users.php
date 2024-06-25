<?php
$page = "Users";
include('includes/header.php'); ?>

<?php include('includes/sidenavbar.php'); ?>


<script>
        $(document).ready(function(){
            $("form").submit(function(event){
                event.preventDefault();
                var fname = $("#fname").val();
                var mname = $("#mname").val();
                var lname = $("#lname").val();
                var bday = $("#bday").val();
                var gender = $("#gender").val();
                var email = $("#email").val();
                var contact = $("#contact").val();
                var address = $("#address").val();
                var uname = $("#uname").val();
                var pass = $("#pass").val();
                var cpass = $("#cpass").val();
                var submit = $("#submit").val();
               

                $(".form-message").load("includes/add_user.php", {
                  fname:fname,
                  mname:mname,
                  lname:lname,
                  bday:bday,
                  gender:gender,
                  email:email,
                  contact:contact,
                  address:address,
                  uname:uname,
                  pass:pass,
                  cpass:cpass,
                  submit:submit
                })
            });
        })

     
    </script>

    <script>
  $(document).ready(function () {
    
    $("form").submit(function (event) {
      event.preventDefault();

      var formData = new FormData();
      formData.append("id", <?php echo $_GET['id'] ?>);
      formData.append("fname", $("#fname").val());
      formData.append("lname", $("#lname").val());
      formData.append("midname", $("#midname").val());
      formData.append("pic", $("#pic")[0].files[0]);
      formData.append("gender", $("#gender").val());
      formData.append("email", $("#email").val());
      formData.append("bday", $("#bday").val());
      formData.append("address", $("#address").val());
      formData.append("pnum", $("#pnum").val());
      formData.append("uname", $("#uname").val());
      formData.append("pass", $("#pass").val());
      formData.append("cpass", $("#cpass").val());
      formData.append("submit", $("#submit").val());

      $.ajax({
        url: "includes/user_update.php",
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

<div class="row text-center mt-3 glass bg-white rounded shadow-lg">
    <div class="col bg-dark rounded p-2 mb-3">
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
            <th class="res">Profile</th>
            <th>Name</th>
            <th class="res">Email</th>
            <th class="res">Address</th>
            <th class="res">Contact Number</th>
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
    },
    "order": [] // Disable ordering
    
});

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
</script>


<?php include('includes/footer.php'); ?>