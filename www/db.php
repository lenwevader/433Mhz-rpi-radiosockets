<?php
$con = mysqli_connect('localhost','root','raspberry','Funksteckdosen');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
?>