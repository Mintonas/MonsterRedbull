<?php

// Inside your signup PHP logic:
$username = $_POST['username'];
$password = $_POST['password'];

// Hash it securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();