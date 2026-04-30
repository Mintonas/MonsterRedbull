<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$conn = new mysqli("localhost","Mintonas","Balionas","Diddy_Club");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Rankings = $_POST["Rankings"];
    $Sizes = $_POST["Sizes"];

    $sql = "INSERT INTO formdata (Rankings, description) VALUES ( $Rankings, $Sizes)";

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
<form method="POST">
    Titel: <input type="text" name="Rankings" required><br><br>
    Beskrivning:<br>
    <textarea name="Sizes" rows="5" cols="40"></textarea><br><br>
    <input type="submit" value="Skicka">
</form>
</body>
</html>