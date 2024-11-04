<?php
session_start();

// Check if the username is available in session
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Handle case when username is not available in session
    echo "Username is not available in session.";
    exit;
}


$message = "";
// Check if the form is submitted
if(isset($_POST['email'])) {


$user = "k70813_monitoring";
$password = "w21ky26L!";
$database = "k70813_monitoring";
$table = "LIST";




    // Connect to the database
    try {
        $db = new PDO("mysql:host=10.35.47.43:3306;dbname=$database", $user, $password);
        $stmt = $db->prepare("SELECT email FROM $table WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }

    // Check if the user's data is fetched successfully
    if($user_data) {
        // Assign email from fetched data
        $old_email = $user_data['email'];
        // Retrieve the new email from the form
        $new_email = $_POST['email'];

        // Check if the new email is already in use
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM $table WHERE email = :new_email");
        $stmt->bindParam(':new_email', $new_email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['count'] > 0) {
            $message = "Email already exists. Please choose a different one.";
       } else {
            // Update the user's email in the database
            $sql = "UPDATE $table SET email = :new_email WHERE username = :username";

            try {
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':new_email', $new_email);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
               
                // Update the email in session data
                $_SESSION['email'] = $new_email;

		header("Location: profile.php");
                exit;
            } catch (PDOException $e) {
                echo "Error updating email: " . $e->getMessage();
            }
        }
    } else {
        // Handle case when user data is not fetched
        echo "User data not found.";
        exit;
    }

    // Close the database connection
    $db = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Email</title>
    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      
</head>
<body>
 <div class="container" style="width: 350px;">
    <h2>Change Email</h2>
	<?php if (!empty($message)) : ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="email">New Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" value="Change Email"> 
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
