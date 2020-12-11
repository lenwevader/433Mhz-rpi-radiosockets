<?php

$pid=$_GET['pid'];
$sid=$_GET['sid'];

include('db.php');

$sql="INSERT INTO ProfilSteckdosen (ProfilId,SteckdosenId) VALUES('$pid','$sid')";

$result = mysqli_query($con,$sql);
echo "Eintrag wurde eingef&uuml;gt";

mysqli_close($con);
?>