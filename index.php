<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <title>Log in Form</title>
    <meta name="google-signin-client_id" content="721336723010-v9nbmr8rrn7frjs6th0e0ojlrdofd31q.apps.googleusercontent.com">
    <meta name="google-site-verification" content="LFloLMXRRXaBybRJb5bGcoOvaLLfD0x0n3P9WimHB3U" />
    <meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      
</head>
<body>





<div class="container" style="width: 350px;">
    <h2>Log in</h2>
<?php
if (isset($_GET['error']) && $_GET['error'] == 1) {
    // Check if there's a message parameter
    if (isset($_GET['message'])) {
        // Display the error message
     echo '<p style="color: red; text-align: center;">' . htmlspecialchars($_GET['message']) . '</p>';
   }
}
?>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
	<a href='resetuser.php' style="font-size:14px; float:right; text-decoration:none; margin-bottom: 10px;margin-top: 2.5px;">Forgot Password?</a>
        <input type="submit" value="Log in">
    </form>
    <a href='newuser.php' class='but' style='margin-bottom: 20px'>Create new account</a>
    <div id="g_id_onload"
         data-client_id="721336723010-v9nbmr8rrn7frjs6th0e0ojlrdofd31q.apps.googleusercontent.com"
         data-ux_mode="redirect"
         data-login_uri="https://monitoring.akt-digital.de/googleLogin.php">
    </div>

    <div class="g_id_signin"
        data-type="standard"
        data-size="large"
        data-theme="outline" 
        data-text="sign_in_with"
        data-shape="rectangular"
        data-logo_alignment="left">
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
 </body>
</html>
