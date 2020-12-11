<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 24.02.2015
 * Time: 14:38
 */

include("db.php");

$sql = "SELECT * FROM Automatik";
$result=mysqli_query($con,$sql);

$time = date('H:i');

while($row=mysqli_fetch_array($result)){
    //echo $row['Zeit']."\r\n";
    //echo $time."\r\n";

    if($row['Zeit']==$time) {
        echo "Equal";
        $sql2 = "SELECT S.UId,S.SysCode,H.Codename FROM Steckdosen S INNER JOIN Hersteller H ON H.Id=S.Hersteller WHERE S.Id=".$row['FunkId'];
        $result2=mysqli_query($con,$sql2);
        $row2=mysqli_fetch_array($result2);

        if($row2['Codename']=="intertechno_switch"){
            exec("sudo pilight-send -p ".$row2['Codename']." -i ".$row2['SysCode']." -u ".$row2['UId']." -f");
        } else {
            exec("sudo pilight-send -p ".$row2['Codename']." -s ".$row2['SysCode']." -u ".$row2['UId']." -f");
        }
        $sql3="DELETE FROM Automatik WHERE Id=".$row['Id'];
        mysqli_query($con,$sql3);
    }
}
mysqli_close($con);



?>