<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 26.02.2015
 * Time: 22:09
 */

include("db.php");

$sql = "SELECT S.UId,S.SysCode,H.Codename FROM Steckdosen S INNER JOIN Hersteller H ON S.Hersteller=H.Id WHERE S.Id IN (SELECT PS.SteckdosenId FROM ProfilSteckdosen PS INNER JOIN Profil P ON P.Id=PS.ProfilId WHERE P.Name='Panik')";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    if ($row['Codename'] == "intertechno_switch") {
        exec("sudo pilight-send -p " . $row['Codename'] . " -i " . $row['SysCode'] . " -u " . $row['UId'] . " -t");
        //echo "sudo /home/pi/pilight/pilight-send -p " . $row['Codename'] . " -i " . $row['SysCode'] . " -u " . $row['UId'] . " -f\n";
    } else {
        exec("sudo pilight-send -p " . $row['Codename'] . " -s " . $row['SysCode'] . " -u " . $row['UId'] . " -t");
        //echo "sudo /home/pi/pilight/pilight-send -p " . $row['Codename'] . " -s " . $row['SysCode'] . " -u " . $row['UId'] . " -f\n";
    }
}
mysqli_close($con);


?>