<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      
    <title>Password Reset</title>
</head>
<body>
<?php

function decryptEmail($encoded, $key) {
    $cipher = "aes-256-cbc";
    $encoded = urldecode($encoded);
    $data = base64_decode($encoded);
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}

// Your encryption key (replace with your own key)
$key = "ReplaceWithYourEncryptionKey";


if(isset($_GET['email'])) {
      $encrypted_email = $_GET['email'];
    $email = decryptEmail($encrypted_email, $key);
} 
?>
<div class="container" style="width: 350px;">
    <h3 style="  text-align: center; vertical-align: middle;">Enter new password to reset password!</h3>
      <form id="resetForm" action="resetdb.php?email=<?php echo urlencode($email); ?>" method="post" onsubmit="return validatePassword()">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirmPassword">Confirm New Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <input type="submit" value="Reset password" class="blue-bg">
    </form>
</div>

<script>
    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        if (password != confirmPassword) {
            alert("Passwords do not match!");
            return false;
        }
        return true;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
