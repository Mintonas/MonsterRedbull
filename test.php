<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "Mintonas", "Balionas", "Diddy_Club");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Rankings = trim($_POST["Rankings"]);
    $Sizes = trim($_POST["Sizes"]);

    if (!empty($Rankings) && !empty($Sizes)) {

        $stmt = $conn->prepare("INSERT INTO Listings (Rankings, Sizes) VALUES (?, ?)");
        $stmt->bind_param("ss", $Rankings, $Sizes);

   
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Data saved successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        $message = "<p style='color: red;'>Please fill out all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php echo $message; ?>

    <form method="POST">
        Titel: <input type="text" name="Rankings" required><br><br>
        Beskrivning:<br>
        <textarea name="Sizes" rows="5" cols="40" required></textarea><br><br>
        <input type="submit" value="Skicka">
    </form>
</body>
</html>