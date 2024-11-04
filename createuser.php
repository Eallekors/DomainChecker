<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

session_start();

// Check if form is submitted
if(isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // Extract form data
    $servername = "10.35.47.43:3306";
    $username = "k70813_monitoring";
    $password = "w21ky26L!";
    $database = "k70813_monitoring";
    $name = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $email_check_sql = "SELECT * FROM LIST WHERE email = ?";
    $stmt = $conn->prepare($email_check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $email_check_result = $stmt->get_result();

    if ($email_check_result->num_rows > 0) {
        // Email already exists
        header("Location: newuser.php?error=email_exists");
        exit;
    }

    // Check if username already exists
    $username_check_sql = "SELECT * FROM LIST WHERE BINARY username = ?";
    $stmt = $conn->prepare($username_check_sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $username_check_result = $stmt->get_result();

    if ($username_check_result->num_rows > 0) {
        // Username already exists
        header("Location: newuser.php?error=username_exists");
        exit;
    }

    // Generate a random verification code
    $verification_code = rand(100000, 999999);

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Store user data in session
    $_SESSION['registration_data'] = array(
        'username' => $name,
        'password' => $hashed_password,
        'email' => $email,
        'verification_code' => $verification_code
    );

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'erki.allekors@gmail.com'; // Your SMTP username
    $mail->Password = 'zqlc cbjl ajmr hzca'; // Your SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Email content
    $mail->setFrom('erki.allekors@gmail.com');
    $mail->addAddress($email); // Add a recipient
    $mail->Subject = 'Email verification request';
    $mail->isHTML(true); // Set email format to HTML
    $mail->Body = '
        <html> 
        <body>
		<p>Email verification code :  <b>' . $verification_code . '</b></p>
        </body>
        </html>
    ';

    // Send verification email
    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // Redirect to the verification form
        header("Location: verify.php");
        exit;
    }
} else {
    // Redirect if form data is not submitted
    header("Location: index.php");
    exit;
}
?>
