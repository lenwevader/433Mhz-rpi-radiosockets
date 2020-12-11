<?php

$q=$_GET['id'];
include('db.php');

//$sql="DELETE Steckdosen,Zeit FROM Steckdosen,Zeit WHERE Steckdosen.Id=Zeit.FunkId AND Steckdosen.Id=$q";

$sql1="DELETE FROM ProfilSteckdosen WHERE Id=$q";

$result1 = mysqli_query($con,$sql1);

echo "Eintrag wurde gel&ouml;scht";

mysqli_close($con);
?>