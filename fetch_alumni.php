<?php
include 'db.php';

$result = $conn->query("SELECT name, email, batch, branch, state, image FROM users ORDER BY id DESC");

$alumni = [];
while($row = $result->fetch_assoc()) {
    $alumni[] = $row;
}

header('Content-Type: application/json');
echo json_encode($alumni);
?>