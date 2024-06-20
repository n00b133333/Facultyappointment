
<?php
  $page='Profile'; 
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
     
     
      formData.append("oldpass", $("#oldpass").val());
      formData.append("newpass", $("#newpass").val());
      formData.append("cpass", $("#cpass").val());
      formData.append("submit", $("#submit").val());

      $.ajax({
        url: "includes/change_password.php",
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


<div class="w-100 text-center">
  <div class="right-content ">
    <h3 class="m-4">  Profile / Change Password</h3>


    
    <div class="table-container m-4 text-start">

    <form action="includes/update.php" method="post" enctype="multipart/form-data">
<!--cards-->
    <div class="card shadow w-50 mx-auto" >
  <div class="card-body row gap-3 ">
   
   
   <div class="col row ">
   <div class="mb-3 ">

  <label for="exampleFormControlInput1" class="form-label">Enter Old Password</label>
  <input type="password" class="form-control shadow-sm " name="oldpass" id="oldpass"  >

</div>
<div class="mb-3 ">

  <label for="exampleFormControlInput1" class="form-label">Enter New Password</label>
  <input type="password" class="form-control shadow-sm" id="newpass" name="newpass" >

</div>
<div class="mb-3 ">

<label for="exampleFormControlInput1" class="form-label">Re-type New Password</label>
<input type="password" class="form-control shadow-sm" id="cpass" name="cpass"   >

</div>











   </div>

  

   
  
<div class="col col-12 text-center"> <a href="profile.php" class="btn btn-dark me-3">Back</a> <button type="submit" id="submit" class="btn btn-success">Save Changes</button> </div>

</form>



  
  </div>
 
</div>


    </div>

    <div class="form-message"></div>
    </div>

</main>
</div>

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