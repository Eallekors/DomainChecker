<?php
// Check if the email parameter is provided in the URL
if(isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];
} else {
    // Handle case when email parameter is not provided
    echo "Email parameter is missing.";
    exit;
}

// Check if the new password is submitted
if(isset($_POST['password'])) {
    // Retrieve the new password from the form
    $new_password = $_POST['password'];


    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the database
 	$servername = "10.35.47.43:3306";
	$username = "k70813_monitoring";
	$password = "w21ky26L!";
	$dbname = "k70813_monitoring";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the user's password in the database
    $sql = "UPDATE LIST SET password = '$hashed_password' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $conn->close();
} else {
    // Handle case when new password is not submitted
    echo "New password is missing.";
    exit;
}
?>
