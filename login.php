<?php


$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    if (password_verify($password, $user['password'])) {

        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        
        header("Location: dashboard.php"); 
        exit;
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}