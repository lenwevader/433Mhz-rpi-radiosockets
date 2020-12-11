
<?php
/*$con = mysqli_connect('localhost','root','raspberry','Funksteckdosen');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}*/

include('db.php');

$sql="SELECT * FROM Hersteller";
$result = mysqli_query($con,$sql);

$hersteller=array();

while($row = mysqli_fetch_array($result)) {

    //array_push($hersteller,$row['Name']);
    $hersteller[$row['Id']] = $row['Name'];
}

echo json_encode($hersteller);
mysqli_close($con);
?>
