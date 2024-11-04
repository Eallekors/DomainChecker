<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      
</head>
<body>

<div class="container" style="width: 350px;">
    <h2>Registration</h2>
 <?php
        // Display error message if provided in URL parameter
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error === "email_exists") {
                echo "<p class='error-message'>Email already exists. Please use a different email.</p>";
            } else if ($error === "username_exists") {
                echo "<p class='error-message'>Username already exists. Please choose a different username.</p>";
            } else {
                echo "<p class='error-message'>An unexpected error occurred.</p>";
            }
        }
        ?>
    <form action="createuser.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Create account" class="blue-bg">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>