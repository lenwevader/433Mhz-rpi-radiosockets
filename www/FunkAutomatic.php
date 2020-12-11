<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 24.02.2015
 * Time: 14:08
 */

include("db.php");



$i = $_POST['id'];
$h = $_POST['hersteller'];
$u = $_POST['uid'];
$s = $_POST['scode'];
$on = $_POST['modus'];
$o = $_POST['on'];
//echo json_encode($on);

if ($h == "intertechno_switch") {
    exec("sudo pilight-send -p $h -i $s -u $u $on");
} else {
    exec("sudo pilight-send -p $h -s $s -u $u $on");
}

$sql = "DELETE FROM Automatik WHERE FunkId=$i";
mysqli_query($con, $sql);

if($o=="f") {

    $sql = "SELECT Intervall FROM Steckdosen WHERE Id=$i";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $time = date('H:i', strtotime("+" . $row['Intervall'] . " min"));

    $sql = "INSERT INTO Automatik (FunkId,Zeit) VALUES ($i,'$time')";
    mysqli_query($con, $sql);
}

mysqli_close($con);

?>