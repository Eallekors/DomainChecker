<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to your MySQL database
    $mysqli = new mysqli("10.35.47.43:3306", "k70813_monitoring", "w21ky26L!", "k70813_monitoring");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare a SQL statement to select the hashed password for the provided username
    // Include a check for google_login = 0 (assuming '0' represents non-Google login)
    $sql = "SELECT username, password FROM LIST WHERE BINARY username = ? AND google_login = '0'";
    $stmt = $mysqli->prepare($sql);

    // Bind parameters
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Store the result
    $result = $stmt->get_result();

    // Check if a row is returned
      if ($result->num_rows == 1) {
        // Fetch the hashed password from the result
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Start the session and set a session variable
            session_start();
            $_SESSION['username'] = $row['username'];

            // Redirect to a logged-in page
            header("Location: welcome.php");
            exit;
        } 
            // If password is incorrect, redirect back to index with an error message
            header("Location: index.php?error=1&message=" . urlencode("Invalid username or password"));
            exit;
        
    } 

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
}
?>
