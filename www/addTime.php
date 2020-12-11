<?php

$q=$_GET['id'];
$b=strtoupper($_GET['von']);
$v=strtoupper($_GET['bis']);

include('db.php');

$sql="INSERT INTO Zeit (FunkId,Von,Bis) VALUES('$q','$b','$v')";

$result = mysqli_query($con,$sql);
echo "Eintrag wurde eingef&uuml;gt";

mysqli_close($con);
?>