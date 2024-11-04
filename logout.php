<?php

session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();


// Check for errors
if ($response === false) {
    echo 'Error: Failed to send POST request';
} else {
    echo 'Logout successful';
}

// Redirect to index.php
header("Location: index.php");
exit; // Ensure that script execution stops after redirection
?>
