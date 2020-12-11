<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 26.02.2015
 * Time: 18:18
 */


include("db.php");

$sql = "SELECT * FROM Steckdosen S INNER JOIN Hersteller H ON S.Hersteller=H.Id";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    if ($row['Codename'] == "intertechno_switch") {
        exec("sudo pilight-send -p " . $row['Codename'] . " -i " . $row['SysCode'] . " -u " . $row['UId'] . " -f");
        echo "sudo pilight-send -p " . $row['Codename'] . " -i " . $row['SysCode'] . " -u " . $row['UId'] . " -f\n";
    } else {
        exec("sudo pilight-send -p " . $row['Codename'] . " -s " . $row['SysCode'] . " -u " . $row['UId'] . " -f");
        echo "sudo pilight-send -p " . $row['Codename'] . " -s " . $row['SysCode'] . " -u " . $row['UId'] . " -f\n";
    }
}
mysqli_close($con);

?>