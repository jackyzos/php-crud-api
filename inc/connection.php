<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviesdb";


$db = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($db,"utf8");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
    }

?>
