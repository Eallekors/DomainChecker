<?php
session_start();

	echo "<script>";
	echo "console.log('Session data:', " . json_encode($_SESSION['registration_data']) . ");";
        echo "console.log('Session ID:', '" . session_id() . "');"; // Output session ID
    	echo "</script>";

// Check if the verification code is submitted
if(isset($_POST['verification_code'])) {
    // Extract the verification code submitted by the user
    $entered_verification_code = $_POST['verification_code'];
    
    // Retrieve the verification code stored in the session
    $stored_verification_code = isset($_SESSION['registration_data']['verification_code']) ? $_SESSION['registration_data']['verification_code'] : null;
    
    // Compare the entered verification code with the stored one
    if($entered_verification_code == $stored_verification_code) {
        // Verification code matched, mark the email as verified in the database
        
        // Connect to the database
        $servername = "10.35.47.43:3306";
	$username = "k70813_monitoring";
	$password = "w21ky26L!";
	$database = "k70813_monitoring";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Extract user data from session
        $username = $_SESSION['registration_data']['username'];
        $hashed_password = $_SESSION['registration_data']['password'];
        $email = $_SESSION['registration_data']['email'];
        
        // Insert user data into the database
        $sql = "INSERT INTO LIST (username, password, email) VALUES ('$username','$hashed_password','$email')";
        
        if ($conn->query($sql) === TRUE) {
            // Email verified and user inserted into the database
		 header("Location: index.php");
        	exit;
        } else {
            echo "Error inserting user: " . $conn->error;
        }
        
        // Close the database connection
        $conn->close();
        
        // Clear the session data
        unset($_SESSION['registration_data']);
        
        // End the session
        session_destroy();


    } else {
        // Verification code does not match
        echo "Verification code is incorrect. Please try again.";
    }
} else {
    // Verification code form is not submitted, display the form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
</head>
<body>
<div class="container" style="width: 350px">
    <h2>Email Verification</h2>
    <form method="post" action="verify.php">
        <label for="verification_code">Enter Verification Code:</label><br>
        <input type="text" id="verification_code" name="verification_code" required><br>
        <button type="submit">Verify</button>
    </form>
</div>
</body>
</html>
<?php
}
?>
