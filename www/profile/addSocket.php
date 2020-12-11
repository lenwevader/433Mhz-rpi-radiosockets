<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lars
 * Date: 26.02.2015
 * Time: 23:56
 */

$pid=$_GET['pid'];
$sid=$_GET['sid'];

include('../db.php');

$sql="INSERT INTO ProfilSteckdosen (ProfilId,SteckdosenId) VALUES('$pid','$sid')";

$result = mysqli_query($con,$sql);

mysqli_close($con);


?>