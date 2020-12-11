<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 24.02.2015
 * Time: 16:26
 */

include("db.php");

$i = $_POST['id'];

$sql = "SELECT * FROM Automatik WHERE FunkId=$i";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    echo json_encode("false");
} else{
    echo json_encode("true");
}

?>