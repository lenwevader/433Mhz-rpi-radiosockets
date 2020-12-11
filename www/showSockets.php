
<?php
/*$con = mysqli_connect('localhost','root','raspberry','Funksteckdosen');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}*/

include('db.php');

//$sql="SELECT * FROM Steckdosen,Hersteller WHERE Steckdosen.Hersteller=Hersteller.Id";
$sql="SELECT S.Id, S.Name, S.UId, S.SysCode, H.Name AS HName, H.Id AS HId FROM Steckdosen S INNER JOIN Hersteller H ON H.Id=S.Hersteller";
$result = mysqli_query($con,$sql);

$alt=false;

$response="";

$response.="<table border='1' class='sockets'>
<tr>
<th>Name</th>
<th>Hersteller</th>
<th>Unit-Id</th>
<th>System-Code</th>
<th></th>
<th></th>
</tr>";

while($row = mysqli_fetch_array($result)) {
  if($alt==true){
    $response.="<tr class='alt'>";
  } else{
    $response.="<tr>";
  }
  $alt=!$alt;
  $response.= "<td>" . $row['Name'] . "</td>
  <td>" . $row['HName'] . "</td>
  <td>" . $row['UId'] . "</td>
  <td>" . $row['SysCode'] . "</td>
  <td>
  <form action=\"changeSockets.php\" method=\"GET\">
  <input type=\"hidden\" name=\"id\" value=\"".$row['Id']."\" />
  <input type='submit' value='Bearbeiten'>
  </form></td>
  <td><input type='button' onclick=\"deleteSocket(".$row['Id'].")\" value=\"L&ouml;schen\"></td>
  </tr>";
}
$response.="</table>";

echo $response;

mysqli_close($con);
?>
