<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$servername = "10.35.47.43:3306";
$username = "k70813_monitoring";
$password = "w21ky26L!";
$database = "k70813_monitoring";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $database);


// Check connection
if ($conn->connect_error) {
    // If there's a connection error, check the error message to determine the cause
    if ($conn->connect_errno === 1045) {
        // 1045 error code indicates incorrect username or password
        die("Connection failed: Incorrect username or password");
    } elseif ($conn->connect_errno === 1049) {
        // 1049 error code indicates unknown database
        die("Connection failed: Unknown database");
    } else {
        // For any other connection error, display the generic error message
        die("Connection failed: " . $conn->connect_error);
    }
}

echo "Connected successfully";

// Close connection
$conn->close();
?>

