<?php 

function login($uname, $pass)
{
$sql = "SELECT * from admin where 'uname' = $uname AND 'pass' = $pass";


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