<html>
<head>
    <title>
        Gruppe bearbeiten
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">

        function deleteT(id) {
            $.ajax({
                type: "GET",
                url: "deleteTime.php",
                data: {'id': id}
            });

            $.ajax({
                type: "POST",
                url: "../updateCron.php"
            });

            location.reload();
        }

        function addT(id) {
            if($('#von').val()!="" && $('#bis').val()!="") {
                var patt = /\d{2}\:\d{2}/;
                if((patt.test($('#von').val()) || $('#von').val().toLowerCase()=="a" || $('#von').val().toLowerCase()=="u") &&
                    (patt.test($('#bis').val()) || $('#bis').val().toLowerCase()=="a" || $('#bis').val().toLowerCase()=="u")) {

                    $.ajax({
                        type: "GET",
                        url: "addTime.php",
                        data: {'id': id, 'von': $('#von').val(), 'bis': $('#bis').val()}
                    });

                    $.ajax({
                        type: "POST",
                        url: "../updateCron.php"
                    });

                    location.reload();
                } else{
                    alert("Geben Sie die Zeiten im Format HH:MM an.")
                }
            } else {
                alert("Tragen Sie Anfangs- und Endzeitpunkt ein.");
            }
        }

        function deleteSocket(id){

            $.ajax({
                type: "GET",
                url: "../deleteProfile.php",
                data: {'id': id}
            });

            $.ajax({
                type: "POST",
                url: "../updateCron.php"
            });

            location.reload();
        }

        function updateProfile(id) {
            //alert($('#hersteller').val());
            $.ajax({
                type: "GET",
                url: "updateProfile.php",
                data: {'id': id, 'name': $('#name').val()}
            });

            $.ajax({
                type: "POST",
                url: "../updateCron.php"
            });

            location.reload();
        }

        $(function () {
            $(document).on('click', '#addSocket', function (e) {
                //alert( $('#profileselect').val());
                $.ajax({
                    type: "GET",
                    url: "addSocket.php",
                    data: {
                        'sid': $('#socketselect').val(),
                        'pid': new RegExp('[\?&amp;]id=([^&amp;#]*)').exec(window.location.href)[1]
                    }
                });
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../updateCron.php"
                });
                location.reload();
            });
        });

    </script>
    <link rel="stylesheet" type="text/css" href="../steckdosen.css">
</head>

<body>
<div>
<h1>Gruppe bearbeiten</h1>

<?php

$q=$_GET['id'];

include('../db.php');


//$sql1="SELECT S.Id, S.UId, S.SysCode, S.Name, H.Id AS HId, H.Name AS HName, H.Codename FROM Hersteller H, Steckdose S INNER JOIN Steckdose ON H.Id=S.Hersteller";

$sql1="SELECT * FROM Profil WHERE Id=$q";
$sql2="SELECT * FROM Profilzeit WHERE ProfilId=$q";

$result1 = mysqli_query($con,$sql1);
$result2 = mysqli_query($con,$sql2);

$row1 = mysqli_fetch_array($result1); //Profil
echo "
Name: <input type='text' value=\"".$row1['Name']."\" id='name'>

<input type='button' onclick='updateProfile(".$row1['Id'].")' value='Aktualisieren'>
<br><br>";

// Zeitentabelle wird erstellt
echo "<table class='sockets'>
  <tr>
  <th>Von</th>
  <th>Bis</th>
  <th></th>
  </tr>";

$alt=false;

if(mysqli_num_rows($result2)>0){

    while($row2= mysqli_fetch_array($result2)) {
        if($alt==true){
            echo "<tr class='alt'>";
        }else{
            echo "<tr>";
        }
        echo "<td>" . $row2['Von'] . "</td>";
        echo "<td>" . $row2['Bis'] . "</td>";
        echo "<td><input type=\"button\" onclick=\"deleteT(".$row2['Id'].")\" value=\"L&ouml;schen\" size='10em' style=\"width:100%\"></td>";
        echo "</tr>";
    }
}
echo "<tr>
  <td><input type='text' id='von' size='10'>
  <td><input type='text' id='bis' size='10'></td></td>
  <td><input type='submit' onclick='addT(".$q.")' value='Hinzuf&uuml;gen'></td>
  </tr>";
echo "</table>";

//$sql="SELECT S.Id, S.Name, PS.Id FROM Steckdosen S WHERE S.Id IN (SELECT PS.SteckdosenId FROM ProfilSteckdosen PS WHERE PS.SteckdosenId=S.Id AND PS.ProfilId=$q)";

$sql="SELECT PS.Id,S.Name,S.Id AS SId FROM ProfilSteckdosen PS INNER JOIN Steckdosen S ON S.Id=PS.SteckdosenId WHERE ProfilId=$q";
$result=mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0){

    echo "<h4>Zugehörige Steckdosen</h4>
    <table class='sockets'>
    <tr>
      <th>Name</th>
      <th></th>
    </tr>";

    while($row= mysqli_fetch_array($result)) {
        if($alt==true){
            echo "<tr class='alt'>";
        }else{
            echo "<tr>";
        }
        echo "<td><a href=\"..\changeSockets.php?id=".$row['SId']."\">" . $row['Name'] . "</a></td>";
        echo "<td><input type=\"button\" onclick=\"deleteSocket(".$row['Id'].")\" value=\"L&ouml;schen\" size='10em'></td>";
        echo "</tr>";
    }
    echo"</table>";
}

echo "<h4>Steckdose hinzufügen</h4>";

$sql="SELECT Id,Name FROM Steckdosen WHERE Id NOT IN (SELECT SteckdosenId FROM ProfilSteckdosen WHERE ProfilId=$q)";
$result = mysqli_query($con,$sql);

$response="<select class=\"Profiles\" id=\"socketselect\">";
if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)) {
        $response.="<option value=\"".$row['Id']."\">".$row['Name']."</option>";
    }
    $response.="</select>";
    $response.="<input type='button' class='Profiles' id='addSocket' value='Steckdosen hinzufügen'>";
}
else{
    $response="Keine Steckdosen vorhanden.";
}

echo $response;

mysqli_close($con);
?>


<div id="message"></div>
<br>
<a href="Profile.html">Zur&uuml;ck</a>
</div>
</body>
</html>