<?php

$u=$_GET['uid'];
$s=$_GET['scode'];
$n=$_GET['name'];
$h=$_GET['hersteller'];

include('db.php');

$sql="INSERT INTO Steckdosen (UId,SysCode,Name,Hersteller) VALUES('$u','$s','$n','$h')";

$result = mysqli_query($con,$sql);
mysqli_close($con);
echo json_encode("Eintrag wurde eingtragen.");

?>