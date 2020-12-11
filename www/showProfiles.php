
<?php
/*$con = mysqli_connect('localhost','root','raspberry','Funksteckdosen');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}*/

include('db.php');
$id=$_GET['id'];

//$sql="SELECT * FROM ProfilSteckdosen PS INNER JOIN Profil P ON P.Id=PS.Id WHERE PS.SteckdosenId=$id";
//$sql="SELECT * FROM Profil";

$sql="SELECT PS.Id,P.Name,P.Id As PId FROM ProfilSteckdosen PS INNER JOIN Profil P ON PS.ProfilId=P.Id WHERE PS.SteckdosenId=$id";
$result = mysqli_query($con,$sql);
//echo $sql;
if(mysqli_num_rows($result)>0) {
    $alt = false;

    $response = "";

    $response .= "<table border='1' id='sockets'>
<tr>
<th>Name</th>
<th></th>
</tr>";

    while ($row = mysqli_fetch_array($result)) {
        if ($alt == true) {
            $response .= "<tr class='alt'>";
        } else {
            $response .= "<tr>";
        }
        $alt = !$alt;
        $response .= "<td><a href=\"Profile/changeProfile.php?id=".$row['PId']."\">". $row['Name'] . "</a></td>
  <td><input type='button' onclick=\"deleteProfile(" . $row['Id'] . ")\" value=\"L&ouml;schen\"></td>
  </tr>";
    }
    $response .= "</table>";

    echo $response;
} else{
    echo json_encode(null);
}

mysqli_close($con);
?>
