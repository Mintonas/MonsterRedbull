<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Connection to database
$conn = new mysqli("localhost", "Mintonas", "Balionas", "Diddy_Club");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Turns into registration succesfull or username alr in use
$message = "";

//Isset checks if username alr in use
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'], $_POST['password'])) {
        //trim removes spaces
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        //empty makes sure that everything is filled in
        if (!empty($username) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // ? - placeholder incase sql injection
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            //Attaches values to place holders (ss) for string
            $stmt->bind_param("ss", $username, $hashed_password);

            try {
                if ($stmt->execute()) {
                    $message = "<p style='color: green;'>Registration successful! <a href='login.php'>Login here</a></p>";
                }
            } catch (mysqli_sql_exception $e) {
                $message = "<p style='color: red;'>Username already taken. Try another one!</p>";
            }
            $stmt->close();
        } else {
            $message = "<p style='color: red;'>Please fill in all fields.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
    <h2>Create an Account</h2>
    <?php echo $message; ?>
    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Log in here</a></p>
</body>
</html>