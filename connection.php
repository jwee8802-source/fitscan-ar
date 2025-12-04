<?php
$servername = "mysql-highdreams.alwaysdata.net";
$username = "439165";
$password = "Skyworth23";
$database = "highdreams_1";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
