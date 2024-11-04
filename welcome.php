<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) && !isset($_SESSION['email'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit;
}

// Retrieve the username from the session
$username = $_SESSION['username'];


$user = "k70813_monitoring";
$password = "w21ky26L!";
$database = "k70813_monitoring";
$table = "LIST";

try {
    $db = new PDO("mysql:host=10.35.47.43:3306;dbname=$database", $user, $password);
    $stmt = $db->prepare("SELECT username, password, email FROM $table WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">                
    <link rel="stylesheet" type="text/css" href="styles.css"  />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">      
    <title>Domain monitor</title>
</head>
<body>
<div class="navigation">
    <a href="#" class="active">Home</a>
    <?php if (!isset($_SESSION['name'])): ?>
        <a href="profile.php">Profile</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <?php if(isset($_SESSION['name'])): ?>
        <h2 class="title">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <?php else: ?>
        <h2 class="title">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Unknown'); ?>!</h2>
    <?php endif; ?>





<div class="d-flex justify-content-center" style="margin-top: 25px">
  <div class="spinner-border" role="status" id="loadingMessage">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<div style="text-align: center;">
    <table id="websiteTable" style="display:none;">
        <tr>
            <th>Website</th>
            <th>Status</th>
        </tr>
    </table>

    <button onclick="openModal()" id="addUrl" style="display: none;">Add URL</button>
</div>

<!-- The Modal -->
<div id="addUrlModal" class="modalNS">
    <!-- Modal content -->
    <div class="modal-contentNS" >
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add URL</h2>
        <form id="addUrlForm">
            <label for="url">URL:</label>
            <input type="text" id="url" name="url" required>
            <button type="submit">Add URL</button>
        </form>
    </div>
</div>
</div>
<script>
$(document).ready(function() {
    function checkStatus() {
        $.ajax({
            url: "check-status.php", // PHP script to check status
            type: "GET",
            success: function(data) {
                $('#loadingMessage').hide();
		$('#addUrl').show();
                $('#websiteTable').show(); // Show table after data arrives

		

                if (data.trim() === '') {
                    $('#websiteTable').html('<tr><td colspan="2" >No logged domains</td></tr>');
                } else {
                    $('#websiteTable').html(data); // Update table with new status
                }
            }
        });
    }
    // Function to handle form submission
    $('#addUrlForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var url = $('#url').val(); // Get the URL value from the input field

        if (!url.startsWith('http://') && !url.startsWith('https://')) {
            url = 'https://' + url;
        }        
        // AJAX request to add_url.php
        $.ajax({
            url: "add-url.php",
            type: "POST",
            data: { url: url },
            success: function(response) {
                // Reload the table after adding the URL
                checkStatus();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
	closeModal();
    });

	

    // Periodically check status every 5 seconds (adjust as needed)
     setInterval(checkStatus, 1000);
});

$(document).keydown(function(event) {
        if (event.keyCode === 27) { // ESC key
            closeModal();
        }
    });



// Function to open the modal
function openModal() {
    $('#addUrlModal').css('display', 'block');
}

// Function to close the modal
function closeModal() {
    $('#addUrlModal').css('display', 'none');
    $('#url').val('');
}



</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



