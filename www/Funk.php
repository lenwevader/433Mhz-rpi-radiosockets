<?php
$h = $_POST['hersteller'];
$u = $_POST['uid'];
$s = $_POST['scode'];
$on = $_POST['modus'];
echo json_encode($on);

if($h=="intertechno_switch"){
    exec("sudo pilight-send -p $h -i $s -u $u $on");
} else if($h=="raw"){
    echo "raw";
    include('db.php');
    $sql = "SELECT Raw_On,Raw_Off FROM Rawcode WHERE Id=".$s;
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    if($on=="-t") {
        echo "sudo pilight-send -p raw -c '".$row['Raw_On']."'";
        exec("sudo pilight-send -p raw -c '".$row['Raw_On']."'");
    } else{
        exec("sudo pilight-send -p raw -c '".$row['Raw_Off']."'");
    }
}
else {
    exec("sudo pilight-send -p $h -s $s -u $u $on");
}

?>