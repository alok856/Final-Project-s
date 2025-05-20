<?php
$servername = "sql309.infinityfree.com";
$username = "if0_39032858";
$password = "College135";
$database = "if0_39032858_collges";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>