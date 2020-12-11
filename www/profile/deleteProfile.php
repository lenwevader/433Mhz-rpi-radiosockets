<?php

$q=$_GET['id'];
include('../db.php');

//$sql="DELETE Steckdosen,Zeit FROM Steckdosen,Zeit WHERE Steckdosen.Id=Zeit.FunkId AND Steckdosen.Id=$q";

$sql1="DELETE FROM Profil WHERE Id=$q";
$sql2="DELETE FROM Profilzeit WHERE ProfilId=$q";
$sql3="DELETE FROM ProfilSteckdosen WHERE ProfilId=$q";

$result1 = mysqli_query($con,$sql1);
$result2 = mysqli_query($con,$sql2);
$result3 = mysqli_query($con,$sql3);

//echo "Eintrag wurde gel&ouml;scht";

mysqli_close($con);
?>