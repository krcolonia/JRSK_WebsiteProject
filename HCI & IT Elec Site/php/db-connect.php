<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "jrsk_db";

$con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if(!$con)  {
    echo '<script>alert("Failed to Connect to Database. Please contact Website Admin");</script>';
    die;
}

?>