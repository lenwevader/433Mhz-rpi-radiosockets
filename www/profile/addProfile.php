<?php

$n=$_GET['name'];

include('../db.php');

$sql="INSERT INTO Profil (Name) VALUES('$n')";

$result = mysqli_query($con,$sql);
mysqli_close($con);
echo json_encode("Eintrag wurde eingtragen.");

?>