
<?php
/*$con = mysqli_connect('localhost','root','raspberry','Funksteckdosen');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}*/

include('db.php');

//$sql="SELECT * FROM Steckdosen,Hersteller WHERE Steckdosen.Hersteller=Hersteller.Id";
$sql="SELECT * FROM Profil";
$result = mysqli_query($con,$sql);

$response="<select class=\"Profiles\" id=\"profileselect\">";
if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)) {
        $response.="<option value=\"".$row['Id']."\">".$row['Name']."</option>";
    }
    $response.="</select>";
    $response.="<input type='button' class='Profiles' id='addProfiles' value='Gruppe hinzufügen'>";
}
else{
    $response="Keine Gruppen vorhanden.";
}

echo json_encode($response);
mysqli_close($con);
?>
