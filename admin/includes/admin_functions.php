<?php 

function login($uname, $pass, $conn)
{
$sql = "SELECT * from admin where adminusername = '$uname' AND password = '$pass' ";


$resultData = mysqli_query($conn,$sql);
    
if($row = mysqli_fetch_assoc($resultData)){
    return $row;
}
else{
    $results = false;
    return $results;
}

}



?>