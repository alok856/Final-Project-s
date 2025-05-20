<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $batch = $_POST['batch'];
    $branch = $_POST['branch'];
    $state = $_POST['state'];

    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo json_encode(['status'=>'error', 'message'=>'Image upload failed']);
            exit;
        }

        $image = $target_file;
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['status'=>'error', 'message'=>'Email already registered']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (name,email,password,batch,branch,state,image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $password, $batch, $branch, $state, $image);

    if ($stmt->execute()) {
        $_SESSION['user'] = $email;
        echo json_encode(['status'=>'success', 'message'=>'Signup successful']);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Signup failed']);
    }
}
?>