<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) && !isset($_SESSION['email'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit;
}

// Retrieve the username from the session
$username = $_SESSION['username'];

$user = "k70813_monitoring";
$password = "w21ky26L!";
$database = "k70813_monitoring";
$table = "LIST";

try {
    $db = new PDO("mysql:host=10.35.47.43:3306;dbname=$database", $user, $password);
    $stmt = $db->prepare("SELECT id, username, password, email FROM $table WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

function encryptEmail($email, $key) {
    $cipher = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($email, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $encoded = base64_encode($iv . $encrypted);
    return urlencode($encoded);
}

$key = "ReplaceWithYourEncryptionKey";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      
    <title>User Profile</title>
    <style>
	.button-container{
	width: 250px;	
	float: right;
}
 @media screen and (max-width: 600px) {
            table td {
                display: block;
                width: 100%;
                text-align: center;
            }

            .button-container {
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<div class="navigation">
    <a href="welcome.php">Home</a>
    <a href="profile.php" class="active">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2 class="title">Profile</h2>
    <table>
        <tr>
            <td><strong>Username:</strong></td>
            <td><?= htmlspecialchars($user_data['username']) ?></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Password:</strong></td>
            <td><?php echo str_repeat('*', 10); ?></td>
            <td>
                <div class="button-container">
                    <a href="resetpass.php?email=<?= urlencode(encryptEmail($user_data['email'], $key)) ?>" class="but">Reset Password</a>
                </div>
            </td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?php echo htmlspecialchars($user_data['email']); ?></td>
            <td>
                <div class="button-container">
                    <a href="newemail.php" class="but">Change Email</a>
                </div>
            </td>
        </tr>
    </table>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
