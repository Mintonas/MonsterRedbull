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

            // Username format validation and regEx
            if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
                $message = "<p style='color:red;'>Username must be 3-20 characters and contain only letters, numbers, and underscores.</p>";
            } else {
        
                // Convert common leetspeak to letters
                $normalized = strtolower($username);
        
                $replacements = [
                    '0' => 'o',
                    '1' => 'i',
                    '!' => 'i',
                    '2' => 'z',
                    '3' => 'e',
                    '4' => 'a',
                    '@' => 'a',
                    '5' => 's',
                    '$' => 's',
                    '6' => 'g',
                    '7' => 't',
                    '8' => 'b',
                    '9' => 'g'
                ];
        
                $normalized = strtr($normalized, $replacements);
                $normalized = preg_replace('/[^a-z]/', '', $normalized);
        
                // List of banned words
                $bannedWords = [
                    'fuck',
                    'fucking',
                    'motherfucker',
                    'shit',
                    'shitty',
                    'bullshit',
                    'bitch',
                    'bitches',
                    'asshole',
                    'bastard',
                    'dick',
                    'dickhead',
                    'cock',
                    'cocksucker',
                    'pussy',
                    'cunt',
                    'whore',
                    'slut',
                    'twat',
                    'wanker',
                    'prick',
                
                    'retard',
                    'retarded',
                    'idiot',
                    'moron',
                    'dumbass',
                    'stupid',
                    'loser',
                
                    'nigga',
                    'neger',
                    'nigger',
                    'fag',
                    'faggot',
                
                    'pedo',
                    'pedophile',
                    'rapist',
                    'rape',
                    'molester',
                
                    'terrorist',
                    'hitler',
                    'nazi',
                
                    'porn',
                    'pornhub',
                    'xvideos',
                    'xnxx',
                    'onlyfans',
                    'sex',
                    'sexy',
                
                    'kill',
                    'killer',
                    'murder',
                    'murderer',
                    'suicide',
                
                    'cum',
                    'ejaculate',
                    'penis',
                    'vagina',
                    'boobs',
                    'tits',
                    'testicles',
                    'nutsack',
                    'nutted',
                
                    'gaylord',
                    'jackass',
                    'dipshit',
                    'douche',
                    'douchebag',
                    'scumbag',
                    'pieceofshit'
                
                ];
        
                $containsBadWord = false;
        
                foreach ($bannedWords as $word) {
                    if (strpos($normalized, $word) !== false) {
                        $containsBadWord = true;
                        break;
                    }
                }
        
                if ($containsBadWord) {
                    $message = "<p style='color:red;'>Username contains inappropriate language.</p>";
                } else {
        
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
                    $stmt = $conn->prepare(
                        "INSERT INTO users (username, password) VALUES (?, ?)"
                    );
        
                    $stmt->bind_param("ss", $username, $hashed_password);
        
                    try {
                        if ($stmt->execute()) {
                            $message = "<p style='color:green;'>Registration successful! <a href='login.php'>Login here</a></p>";
                        }
                    } catch (mysqli_sql_exception $e) {
                        $message = "<p style='color:red;'>Username already taken. Try another one!</p>";
                    }
        
                    $stmt->close();
                }
            }
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