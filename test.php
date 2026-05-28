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
    

    if (isset($_POST["Rankings"], $_POST["Sizes"], $_POST["Names"], $_POST["Ages"])) {
        
        $Rankings = trim($_POST["Rankings"]);
        $Sizes = trim($_POST["Sizes"]);
        $Names = trim($_POST["Names"]);
        $Ages = trim($_POST["Ages"]);

        if (!empty($Rankings) && !empty($Sizes) && !empty($Names) && !empty($Ages)) {
            
            $stmt = $conn->prepare("INSERT INTO Listing (Rankings, Sizes, Names, Ages) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $Rankings, $Sizes, $Names, $Ages);

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
        Namn: <input type="text" name="Names" required><br><br>
        Ålder: <input type="text" name="Ages" required><br><br>
        Titel: <input type="text" name="Rankings" required><br><br>
        Beskrivning:<br>
        <textarea name="Sizes" rows="5" cols="40" required></textarea><br><br>
        <input type="submit" value="Skicka">
    </form>
</body>
</html>