<?php

$hostname = "localhost";
$username = "alba";
$password = "Albyruska_8";
$dbname = "chatapp";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
   echo "Database connection error" . mysqli_connect_error();
}

?>