<?php
// Include the PHPMailer Autoload
require 'vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);



$serverIP = $_SERVER['SERVER_ADDR'];

// Database connection
$servername = "10.35.47.43:3306";
$username = "k70813_monitoring";
$password = "w21ky26L!";
$dbname = "k70813_monitoring";// Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// email encryption
function encryptEmail($email, $key) {
    $cipher = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($email, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $encoded = base64_encode($iv . $encrypted);
    return urlencode($encoded);
}

$key = "ReplaceWithYourEncryptionKey";


$to = $_POST['email'];
$encrypted_email = encryptEmail($to, $key);
$encoded_email = urlencode($to);

// Query to check if the email exists
$sql = "SELECT * FROM LIST WHERE email = '$to'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email exists, proceed with sending the reset password email

    // Create a new PHPMailer instance
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
    $mail->addAddress($to); // Add a recipient
    $mail->Subject = 'Password Reset Request';
    $mail->isHTML(true); // Set email format to HTML
    $mail->Body = '
        <html>
        <head>
            <title>HTML Email</title>
        </head>
        <body>
          <a href="http://monitoring.akt-digital.de/resetpass.php?email=' . urlencode($encrypted_email) . '" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Reset password</a>
        </body>
        </html>
    ';

    // Send the email
    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        header("Location: /");
        exit(); // Make sure to exit after redirecting
    }
} else {
    // Email does not exist in the databas	e
    header("Location: /resetuser.php?error=email_not_exists");
    exit(); // Make sure to exit after redirecting
}

$conn->close(); // Close the database connection
?>
