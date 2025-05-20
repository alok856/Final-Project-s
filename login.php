<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hash);
    if ($stmt->fetch()) {
        if (password_verify($pass, $hash)) {
            $_SESSION['user'] = $email;
            echo json_encode(['status'=>'success', 'message'=>'Login successful']);
        } else {
            echo json_encode(['status'=>'error', 'message'=>'Invalid password']);
        }
    } else {
        echo json_encode(['status'=>'error', 'message'=>'User not found']);
    }
}
?>