<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 23.02.2015
 * Time: 16:00
 */
include("db.php");

$i = $_POST['id'];
$on = $_POST['modus'];
echo $on;
//echo json_encode($on);

//"SELECT PZ.Von,PZ.Bis FROM ProfilSteckdosen PS INNER JOIN Profilzeit PZ ON PZ.ProfilId=PS.ProfilId WHERE PS.SteckdosenId=".$row1['Id']"
$sql="SELECT S.Name,S.UId,S.SysCode,H.CodeName FROM ProfilSteckdosen PS INNER JOIN Steckdosen S ON S.Id=PS.SteckdosenId INNER JOIN Hersteller H ON H.Id=S.Hersteller WHERE ProfilId=$i";
$result=mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)){

    if ($row['CodeName'] == "intertechno_switch") {
        exec("sudo pilight-send -p ".$row['CodeName']." -i ".$row['SysCode']." -u ".$row['UId']." $on");

    }
    else if($row["CodeName"]=="raw"){
        echo "raw";
        $sql2 = "SELECT Raw_On,Raw_Off FROM Rawcode WHERE Id=".$row['SysCode'];
        echo  "SELECT Raw_On,Raw_Off FROM Rawcode WHERE Id=".$row['SysCode'];
        $result2 = mysqli_query($con,$sql2);
        $row2 = mysqli_fetch_assoc($result2);

        if($on=="-t") {
            echo "sudo pilight-send -p raw -c '".$row2['Raw_On']."'";
            exec("sudo pilight-send -p raw -c '".$row2['Raw_On']."'");
        } else{
            exec("sudo pilight-send -p raw -c '".$row2['Raw_Off']."'");
        }
    }else {
        exec("sudo pilight-send -p ".$row['CodeName']." -s ".$row['SysCode']." -u ".$row['UId']." $on");
        echo "sudo pilight-send -p ".$row['CodeName']." -s ".$row['SysCode']." -u ".$row['UId']." $on";
    }
}

?>