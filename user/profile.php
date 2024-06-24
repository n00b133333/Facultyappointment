
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
      formData.append("id", <?php echo $_SESSION['user_ID'] ?>);
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
    <h3 class="m-4">Profile</h3>


    
    <div class="table-container m-4">

    <form  method="post" enctype="multipart/form-data">
<!--cards-->
    <div class="card shadow " >
  <div class="card-body row gap-3 ">
   <div class="col col-3 text-center"><img src="../uploads/<?php echo userinfo($conn,$_SESSION['user_ID'])['profile'] ?>" id="image_preview" alt="" height="200" width="200"><br> <div class="mt-3 col-11">
 
  <input  type="file" id="pic" class="form-control" name="pic">
</div></div>
   
   <div class="col-9 row ">
   <div class="mb-3 col-4">

  <label for="exampleFormControlInput1" class="form-label">First Name</label>
  <input type="text" class="form-control shadow-sm " name="fname" id="fname" value="<?php echo userinfo($conn,$_SESSION['user_ID'])['u_fname'] ?>" >

</div>
<div class="mb-3 col-4">

  <label for="exampleFormControlInput1" class="form-label">Middle Initial</label>
  <input type="text" class="form-control shadow-sm " id="midname" name="midname"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['u_mname'] ?>">

</div>
<div class="mb-3 col-4">

<label for="exampleFormControlInput1" class="form-label">Last Name</label>
<input type="text" class="form-control shadow-sm" id="lname" name="lname"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['u_lname'] ?>" >

</div>

<div class="mb-3 col-6" >

<label for="exampleFormControlInput1" class="form-label">Address</label>
<input type="text" class="form-control shadow-sm " id="address"  name="address"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['address'] ?>" >

</div>

<div class="mb-3 col-6" >

<label for="exampleFormControlInput1" class="form-label">Contact Number</label>
<input type="text" class="form-control shadow-sm " id="pnum"  name="pnum"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['contact_number'] ?>" >

</div>

<div class="mb-3 col-4" >

<label for="exampleFormControlInput1" class="form-label">Birh Date</label>
<input type="date" class="form-control shadow-sm " id="bday"  name="bday"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['bday'] ?>" >

</div>


<div class="mb-3 col-4" >

<label for="exampleFormControlInput1" class="form-label">Gender</label>
<select class="form-select shadow-sm " id="gender" name="gender" aria-label="Default select example">
<?php 

if(userinfo($conn,$_SESSION['user_ID'])['gender']  == "Male"){
    echo "<option value='Male' selected>Male</option>
    <option value='Female'>Female</option>";
}
else if (userinfo($conn,$_SESSION['user_ID'])['gender'] == "Female"){
    echo "<option value='Male' >Male</option>
    <option value='Female' selected>Female</option>";
}
else{
  echo "<option value='Male'>Male</option>
  <option value='Female'>Female</option>";
}

?>
  
  
</select>

</div>

<div class="mb-3 col-4" >

<label for="exampleFormControlInput1" class="form-label">Email</label>
<input type="email" class="form-control shadow-sm " id="email"  name="email"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['u_email'] ?>" >

</div>

<div class="mb-3 col-6" >

<label for="exampleFormControlInput1" class="form-label">Username</label>
<input type="text" class="form-control shadow-sm " id="uname"  name="uname"  value="<?php echo userinfo($conn,$_SESSION['user_ID'])['u_username'] ?>" >

</div>




<div class="mb-3 col-4">




   </div>

  
<div class="text-start">
<a href="change_password.php" class="btn btn-danger mb-3">Change password</a>
</div>
   
  
<div class="col col-12 text-center">  <button type="submit" id="submit" class="btn btn-success">Save Changes</button> </div>

</form>



  
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