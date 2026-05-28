<?php

// Inside your login PHP logic:
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verify the password against the stored hash
    if (password_verify($password, $user['password'])) {
        // Start the session and log them in!
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        
        header("Location: dashboard.php"); // Redirect to a protected page
        exit;
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}