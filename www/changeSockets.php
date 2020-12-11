<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>
        Steckdose bearbeiten
    </title>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">


        $(function () {
            $(document).on('click', '#addProfiles', function (e) {
                //alert( $('#profileselect').val());
                $.ajax({
                    type: "GET",
                    url: "addProfile.php",
                    data: {
                        'pid': $('#profileselect').val(),
                        'sid': new RegExp('[\?&amp;]id=([^&amp;#]*)').exec(window.location.href)[1]
                    }
                });
                e.preventDefault();
                updateCron();
                location.reload();
            });
        });

        function deleteProfile(id) {
            $.ajax({
                type: "GET",
                url: "deleteProfile.php",
                data: {'id': id}
            });

            updateCron();
            location.reload();
        }

        function deleteT(id) {
            $.ajax({
                type: "GET",
                url: "deleteTime.php",
                data: {'id': id}
            });

            updateCron();

            location.reload();
        }

        function addT(id) {
            if ($('#von').val() != "" && $('#bis').val() != "") {
                var patt = /\d{2}\:\d{2}/;
                var patt2 = /[au][+-]\d*/;
                if ((patt.test($('#von').val()) || $('#von').val().toLowerCase() == "a" || $('#von').val().toLowerCase() == "u") &&
                 (patt.test($('#bis').val()) || $('#bis').val().toLowerCase() == "a" || $('#bis').val().toLowerCase() == "u")) {
                //if (patt.test($('#von').val()) || patt2.test($('#von').val().toLowerCase())) {

                    $.ajax({
                        type: "GET",
                        url: "addTime.php",
                        data: {'id': id, 'von': $('#von').val(), 'bis': $('#bis').val()}
                    });

                    updateCron();

                    location.reload();
                } else {
                    alert("Geben Sie die Zeiten im Format HH:MM an.")
                }
            } else {
                alert("Tragen Sie Anfangs- und Endzeitpunkt ein.");
            }
        }

        function updateSockets(id) {
            //alert($('#hersteller').val());
            $.ajax({
                type: "GET",
                url: "updateSockets.php",
                data: {
                    'id': id,
                    'name': $('#name').val(),
                    'uid': $('#uid').val(),
                    'scode': $('#scode').val(),
                    'hersteller': $('#hersteller').val(),
                    'intervall': $('#intervall').val()
                }
            });

            updateCron();

            location.reload();
        }

        function getProfiles() {
            //alert("Test");
            $.ajax({
                type: "GET",
                url: "getProfiles.php",
                datatype: 'json',
                async: false,
                success: function (data) {
                    $('#knownProfiles').html(JSON.parse(data));
                },
                error: function () {
                    alert("Gruppen konnten nicht geladen werden.");
                }
            });
        }

        function showProfiles() {
            $.ajax({
                type: "GET",
                url: "showProfiles.php",
                data: {'id': new RegExp('[\?&amp;]id=([^&amp;#]*)').exec(window.location.href)[1]},
                datatype: "text",
                success: function (data) {
                    $('#listedProfiles').html(data);
                    if (data != "\r\nnull") {
                        $('#listedProfiles').html(data);
                    } else {
                        $('#listedProfiles').html("Keine Gruppe eingetragen.");
                    }
                }
            });
        }

        function updateCron() {
            $.ajax({
                type: "POST",
                url: "updateCron.php"
            });
        }
        $(document).ready(function () {
            getProfiles();
        });
    </script>
    <link rel="stylesheet" type="text/css" href="steckdosen.css">
</head>

<body>

<h1>Funksteckdose bearbeiten</h1>

<?php

$q = $_GET['id'];

include('db.php');


//$sql1="SELECT S.Id, S.UId, S.SysCode, S.Name, H.Id AS HId, H.Name AS HName, H.Codename FROM Hersteller H, Steckdose S INNER JOIN Steckdose ON H.Id=S.Hersteller";

$sql1 = "SELECT * FROM Hersteller";
$sql2 = "SELECT * FROM Steckdosen WHERE Id=$q";
$sql3 = "SELECT * FROM Zeit WHERE FunkId=$q";

$result1 = mysqli_query($con, $sql1);
$result2 = mysqli_query($con, $sql2);
$result3 = mysqli_query($con, $sql3);

//$row1 = mysqli_fetch_array($result1); //Hersteller
$row2 = mysqli_fetch_array($result2); //Steckdosen
//$row3 = mysqli_fetch_array($result3); //Zeiten

echo "
<table>
<tr><td>Hersteller:</td><td><select id=\"hersteller\">";

while ($row1 = mysqli_fetch_array($result1)) { //Hersteller Select wird generiert

    if ($row1['Id'] == $row2['Hersteller']) {
        echo "<option value=" . $row1['Id'] . " selected>" . $row1['Name'] . "</option>";
    } else {
        echo "<option value=" . $row1['Id'] . ">" . $row1['Name'] . "</option>";
    }
}

// Daten der Steckdose werden aufgelistet
echo "</select></td></tr>

<tr><td>Name:</td><td><input type='text' value=\"" . $row2['Name'] . "\" id='name'></td></tr>
<tr><td>Unit-Id:</td><td><input type='text' value=\"" . $row2['UId'] . "\" id='uid'></td></tr>
<tr><td>System-Code:</td><td><input type='text' value=\"" . $row2['SysCode'] . "\" id='scode'></td></tr>
<tr><td>Intervall:</td><td><input type='text' value=\"" . $row2['Intervall'] . "\" id='intervall'></td></tr>
</table>
<input type='button' onclick='updateSockets(" . $row2['Id'] . ")' value='Aktualisieren'>
<br><br>";

// Zeitentabelle wird erstellt
echo "<table class='sockets'>
  <tr>
  <th>Von</th>
  <th>Bis</th>
  <th></th>
  </tr>";

$alt = false;

if (mysqli_num_rows($result3) > 0) {

    while ($row3 = mysqli_fetch_array($result3)) {
        if ($alt == true) {
            echo "<tr class='alt'>";
        } else {
            echo "<tr>";
        }
        echo "<td>" . $row3['Von'] . "</td>";
        echo "<td>" . $row3['Bis'] . "</td>";
        echo "<td><input type=\"button\" onclick=\"deleteT(" . $row3['Id'] . ")\" value=\"L&ouml;schen\" size='10em' style=\"width:100%\"></td>";
        echo "</tr>";
    }
}
echo "<tr>
  <td><input type='text' id='von' size='10'></td>
  <td><input type='text' id='bis' size='10'></td>
  <td><input type='submit' onclick='addT(" . $q . ")' value='Hinzuf&uuml;gen'></td>
  </tr>";
echo "</table>";

echo "<h4 class=\"listedProfiles\">Eingetragene Gruppen</h4>";

//Eingetragene Gruppen auflisten

$sql = "SELECT PS.Id,P.Name,P.Id As PId FROM ProfilSteckdosen PS INNER JOIN Profil P ON PS.ProfilId=P.Id WHERE PS.SteckdosenId=$q";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $alt = false;

    echo "<table border='1' class='sockets'>
        <tr>
        <th>Name</th>
        <th></th>
        </tr>";

    while ($row = mysqli_fetch_array($result)) {
        if ($alt == true) {
            echo "<tr class='alt'>";
        } else {
            echo "<tr>";
        }
        $alt = !$alt;
        echo "<td><a href=\"Profile/changeProfile.php?id=" . $row['PId'] . "\">" . $row['Name'] . "</a></td>
  <td><input type='button' onclick=\"deleteProfile(" . $row['Id'] . ")\" value=\"L&ouml;schen\"></td>
  </tr>";
    }
    echo "</table>";

} else {
    echo "Keine Gruppen eingetragen";
}

// Existierende Gruppen auflisten

echo "<h4>Gruppe eintragen</h4>";

$sql="SELECT * FROM Profil WHERE Id NOT IN (SELECT ProfilId FROM ProfilSteckdosen WHERE SteckdosenId=$q)";
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

echo $response;

mysqli_close($con);

?>

<br>
<br>
<a href=Steckdosen.html>Zur&uuml;ck</a>

</body>

</html>