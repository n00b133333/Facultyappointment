
<?php
  $page='Notification'; 
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
    <h3 class="m-4">Notification</h3>


    
    <div class="table-container m-4">

    
<!--cards-->
    <div class="card shadow " >
  <div class="card-body row gap-3 ">
   








  
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