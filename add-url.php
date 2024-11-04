<?php
session_start();

// Check if the URL is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["url"])) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    if ($username) {
        $url = $_POST["url"];
        $filename = 'userDomains/' . $username . '.json'; // File path with folder

        // Read existing URLs from the JSON file
        $urls = [];
        if (file_exists($filename)) {
            $jsonData = file_get_contents($filename);
            $urlsData = json_decode($jsonData, true);
            $urls = $urlsData['urls'];
        }

        // Add the new URL to the array of URLs
        $urls[] = $url;

        // Write updated URLs to the JSON file
        $data = ['urls' => $urls];
        file_put_contents($filename, json_encode($data));

        // Redirect back to the index.php page
        header("Location: welcome.php");
        exit;
    }
}
?>
