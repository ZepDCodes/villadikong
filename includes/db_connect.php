<?php
$servername = "resortdb-resort-management.i.aivencloud.com";
$username = "avnadmin";
$password = "AVNS_WB8gfeBtLeEjydhMD_6";
$database = "defaultdb";
$port = 20089;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
