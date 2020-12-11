
<?php
/*$con = mysqli_connect('localhost','root','raspberry','Funksteckdosen');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}*/

include('../db.php');

//$sql="SELECT * FROM Steckdosen,Hersteller WHERE Steckdosen.Hersteller=Hersteller.Id";
$sql="SELECT * FROM Profil";
$result = mysqli_query($con,$sql);

$alt=false;

$response="";

$response.="<table border='1' class='sockets'>
<tr>
<th>Name</th>
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
  <td>
  <form action=\"changeProfile.php\" method=\"GET\">
  <input type=\"hidden\" name=\"id\" value=\"".$row['Id']."\" />
  <input type='submit' value='Bearbeiten'>
  </form></td>
  <td><input type='button' onclick=\"deleteProfile(".$row['Id'].")\" value=\"L&ouml;schen\"></td>
  </tr>";
}
$response.="</table>";

echo $response;

mysqli_close($con);
?>
