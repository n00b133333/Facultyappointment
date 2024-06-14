<?php
$page = "Faculty";
include('includes/header.php'); ?>

<?php include('includes/sidenavbar.php'); ?>




<table id="myTable" class="display ">
    <thead>
        <tr>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Position</th>
            <th>Action</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
    </tbody>
</table>



<script>
   let table = new DataTable('#myTable', {
    // options
});
</script>
<?php include('includes/footer.php'); ?>