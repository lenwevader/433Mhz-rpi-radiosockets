<?php

$i=$_GET['id'];
$u=$_GET['uid'];
$s=$_GET['scode'];
$n=$_GET['name'];
$h=$_GET['hersteller'];
$inter=$_GET['intervall'];

include('db.php');

if($inter=="" || $inter=="0"){
    $inter='NULL';
}


$sql="UPDATE Steckdosen SET UId='$u',SysCode='$s',Name='$n',Hersteller='$h',Intervall=$inter WHERE Id=$i";

$result = mysqli_query($con,$sql);
echo "Eintrag wurde eingef&uuml;gt";
mysqli_close($con);

?>