<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test</title>
</head>
<body>
    <h1>Database Connection Test</h1>
    <?php
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
    echo "<p>Connected successfully</p>";

    // Close connection
    $conn->close();
    ?>
</body>
</html>
