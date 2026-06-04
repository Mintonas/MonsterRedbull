<?php

session_start();

//checks if you logged in (access control)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "Mintonas", "Balionas", "Diddy_Club");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //checking these fields
    if (isset($_POST["FootSize"], $_POST["Height"], $_POST["Names"], $_POST["Ages"])) {
        //reading user input
        $FootSize = trim($_POST["FootSize"]);
        $Height = trim($_POST["Height"]);
        $Names = trim($_POST["Names"]);
        $Ages = trim($_POST["Ages"]);
        //validation 
        if (!empty($FootSize) && !empty($Height) && !empty($Names) && !empty($Ages)) {
            //Inserting info
            $stmt = $conn->prepare("INSERT INTO Listing (Names, Ages, FootSize, Height) VALUES (?, ?, ?, ?)");
            //Binding values
            $stmt->bind_param("ssss", $Names, $Ages, $FootSize, $Height);

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
    <title>Dashboard</title>
</head>
<body>

    <h1>Welcome to the Diddy club, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p><a href="logout.php" style="color: red; font-weight: bold;">(Log Out)</a></p>
    
    <hr>

    <h3>Add New Listing Data</h3>
    <?php echo $message; ?>

    <form method="POST">
        Name: <input type="text" name="Names" required><br><br>
        Age: <input type="text" name="Ages" required><br><br>
        Foot Size: <input type="text" name="FootSize" required><br><br>
        Height: <input type="text" name="Height" required><br><br>
        
        <input type="submit" value="Skicka">
    </form>

    <hr>
<h2>All Listings</h2>

<?php
$result = $conn->query("SELECT * FROM Listing ORDER BY id DESC");

while ($row = $result->fetch_assoc()) {
    echo "<div style='background:#f5f5f5; padding:10px; border-radius:10px; margin:10px'>";

    echo "<b>Name:</b> " . htmlspecialchars($row["Names"]) . "<br>";
    echo "<b>Age:</b> " . htmlspecialchars($row["Ages"]) . "<br>";
    echo "<b>Foot Size:</b> " . htmlspecialchars($row["FootSize"]) . "<br>";
    echo "<b>Height:</b> " . htmlspecialchars($row["Height"]) . "<br>";
    
    echo "</div>";
}
?>

</body>
</html>