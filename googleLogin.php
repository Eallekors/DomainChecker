<?php
require_once 'vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Retrieve the ID token from the POST request
$id_token = $_POST['credential'] ?? null;

// Check if the ID token is present
if ($id_token) {
    $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($id_token);
    
    if ($payload) {
        
        
        $userid = $payload['sub'];
        $email = $payload['email']; // Retrieve the email from the payload
        $name = $payload['name'];
        
        // Check if the email exists in your database table
        // Assuming you have a database connection established
        $pdo = new PDO("mysql:host=10.35.47.43:3306;dbname=k70813_monitoring", "k70813_monitoring", "w21ky26L!");
        $stmt = $pdo->prepare("SELECT * FROM LIST WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
	    // Start a session
            session_start();
            // Email exists, take the username
            $username = $user['username'];
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
            exit; // Stop further execution
        } else {
            // Email doesn't exist, start a separate session
 	    // Start a session
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['username'] =  $userid;
            header("Location: welcome.php");
            exit; // Stop further execution
        }
    } else {
        // Invalid ID token
        echo "Error: Invalid ID token";
    }
} else {
    // ID token not present in the request
    echo "Error: ID token missing";
}
?>