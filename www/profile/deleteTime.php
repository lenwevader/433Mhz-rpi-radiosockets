<?php

$q=$_GET['id'];
include('../db.php');

$sql="DELETE FROM Profilzeit WHERE Id=$q";

$result = mysqli_query($con,$sql);
echo "Eintrag wurde gel&ouml;scht";

mysqli_close($con);
?>