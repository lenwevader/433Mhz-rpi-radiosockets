<?php

//echo "Start";
//$output = shell_exec('sudo crontab -l');
//echo $output."\n";
$pfad="/var/www/html/test.txt";
$datei = fopen($pfad,"w+");

//echo $output;

include('db.php');

$sql1="SELECT S.Id,S.UId,S.SysCode,H.Codename FROM Steckdosen S INNER JOIN Hersteller H ON H.Id=S.Hersteller";

$result1 = mysqli_query($con,$sql1);
//echo count(mysqli_fetch_array($result1));
//fwrite($datei,"00 * * * * sudo python /home/pi/druck.py\n");
fwrite($datei,"00 00 * * * sudo /usr/bin/php /var/www/html/updateCron.php\n");
fwrite($datei,"* * * * * sudo /usr/bin/php /var/www/html/checkAutomatic.php\n");

$angle = 88.5; // Winkel für Sonnenuntergang /-aufgang

while($row1 = mysqli_fetch_array($result1)){
  $sql2="SELECT Von,Bis FROM Zeit WHERE FunkId=".$row1['Id'];
  $result2 = mysqli_query($con,$sql2);
  while($row2 = mysqli_fetch_array($result2)){
          if ($row2['Von'] == "A") {
              $row2['Von'] = date_sunrise(time(), SUNFUNCS_RET_STRING, 53.30, 7.49, $angle, 2);
          } elseif ($row2['Von'] == "U") {
              $row2['Von'] = date_sunset(time(), SUNFUNCS_RET_STRING, 53.30, 7.49, $angle, 2);
          }

          $hv = explode(":", $row2['Von'])[0];
          $mv = explode(":", $row2['Von'])[1];

    if($row2['Bis']=="A"){
      $row2['Bis']=date_sunrise(time(),SUNFUNCS_RET_STRING,53.30,7.49,$angle,2);
    } elseif($row2['Bis']=="U"){
      $row2['Bis']=date_sunset(time(),SUNFUNCS_RET_STRING,53.30,7.49,$angle,2);
    }
    $hb=explode(":",$row2['Bis'])[0];
    $mb=explode(":",$row2['Bis'])[1];
    //echo "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -t\n"
    //echo "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -f\n";
      if($row1['Codename']=="intertechno_switch") {
          fwrite($datei, "$mv $hv * * * sudo pilight-send -p " . $row1['Codename'] . " -i " . $row1['SysCode'] . " -u " . $row1['UId'] . " -t\n");
          fwrite($datei, "$mb $hb * * * sudo pilight-send -p " . $row1['Codename'] . " -i " . $row1['SysCode'] . " -u " . $row1['UId'] . " -f\n");
      }
      if($row1['Codename']=="raw"){

          $sqlRaw = "SELECT Raw_On,Raw_Off FROM Rawcode WHERE Rawcode.Id=".$row1['SysCode'];

          $resultRaw=mysqli_query($con,$sqlRaw);

          while($rowRaw=mysqli_fetch_array($resultRaw)){

              fwrite($datei, "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -c '".$rowRaw['Raw_On']."'\n");
              fwrite($datei, "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -c '".$rowRaw['Raw_Off']."'\n");
          }

      } else{
          fwrite($datei, "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -t\n");
          fwrite($datei, "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -f\n");
      }
  }
    $sql3="SELECT PZ.Von,PZ.Bis FROM ProfilSteckdosen PS INNER JOIN Profilzeit PZ ON PZ.ProfilId=PS.ProfilId WHERE PS.SteckdosenId=".$row1['Id'];
    //echo $sql3;
    $result3 = mysqli_query($con,$sql3);

    while($row3 = mysqli_fetch_array($result3)){
        if($row3['Von']=="A"){
            $row3['Von']=date_sunrise(time(),SUNFUNCS_RET_STRING,53.30,7.49,$angle,2);
        } elseif($row3['Von']=="U"){
            $row3['Von']=date_sunset(time(),SUNFUNCS_RET_STRING,53.30,7.49,$angle,2);
        }
        //echo $row2['Von'];

        $hv = explode(":", $row3['Von'])[0];
        $mv = explode(":", $row3['Von'])[1];

        if($row3['Bis']=="A"){
            $row3['Bis']=date_sunrise(time(),SUNFUNCS_RET_STRING,53.30,7.49,$angle,2);
        } elseif($row3['Von']=="U"){
            $row3['Bis']=date_sunset(time(),SUNFUNCS_RET_STRING,53.30,7.49,$angle,2);
        }
        $hb=explode(":",$row3['Bis'])[0];
        $mb=explode(":",$row3['Bis'])[1];
        //echo "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -t";
        //fwrite($datei, "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -t\n");
        //fwrite($datei, "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -f\n");
        if($row1['Codename']=="intertechno_switch") {
            fwrite($datei, "$mv $hv * * * sudo pilight-send -p " . $row1['Codename'] . " -i " . $row1['SysCode'] . " -u " . $row1['UId'] . " -t\n");
            fwrite($datei, "$mb $hb * * * sudo pilight-send -p " . $row1['Codename'] . " -i " . $row1['SysCode'] . " -u " . $row1['UId'] . " -f\n");
        }
        else if($row1['Codename']=="raw"){

            $sqlRaw = "SELECT Raw_On,Raw_Off FROM Rawcode WHERE Rawcode.Id=".$row1['SysCode'];

            $resultRaw=mysqli_query($con,$sqlRaw);

            while($rowRaw=mysqli_fetch_array($resultRaw)){

                fwrite($datei, "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -c '".$rowRaw['Raw_On']."'\n");
                fwrite($datei, "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -c '".$rowRaw['Raw_Off']."'\n");
            }

        }else{
            fwrite($datei, "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -t\n");
            fwrite($datei, "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -f\n");
        }

        //echo "$mv $hv * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -t\n";
        //echo "$mb $hb * * * sudo pilight-send -p ".$row1['Codename']." -s ".$row1['SysCode']." -u ".$row1['UId']." -f\n";
    }
}

shell_exec("sudo crontab $pfad");
fclose($datei);

?>
