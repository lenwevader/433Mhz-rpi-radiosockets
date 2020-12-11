<?php

$i=$_GET['id'];
$n=$_GET['name'];

include('../db.php');

$sql="UPDATE Profil SET Name='$n' WHERE Id='$i'";

$result = mysqli_query($con,$sql);
echo "Eintrag wurde eingef&uuml;gt";
mysqli_close($con);

?>