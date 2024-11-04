<?php
// Start session
session_start();

require 'vendor/autoload.php';
// Log username to the console if it exists in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

// Function to check if a website is online
function isWebsiteOnline($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
 if ($status_code < 400) {
    if ($status_code !== 200) {
        return '<td style="text-align: center; width: 10px; "><span class="status-green">&#11044;</span></td>' . '<td style="width: 200px; border-right: 1px solid #ddd;">Online | HTTP:' . $status_code . '</td>'; // Online
    } else {
        return '<td style="text-align: center; width: 10px; "><span class="status-green">&#11044;</span></td>' . '<td style="width: 200px; border-right: 1px solid #ddd;">Online</td>' ; // Online
    }
} else {
    return '<td style="text-align: center; width: 10px; "><span class="status-red">&#11044;</span></td>' . '<td style="width: 200px; border-right: 1px solid #ddd; color: red;">HTTP Error: ' . $status_code . '</td>';
}
}

// Function to read URLs from JSON file
function readUrlsFromFile($filename) {
    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        $urlsData = json_decode($jsonData, true);
        return $urlsData['urls'];
    } else {
        return [];
    }
}

// Function to write URLs to JSON file
function writeUrlsToFile($filename, $urls) {
    $data = ['urls' => $urls];
    file_put_contents($filename, json_encode($data));
}

// Read URLs from JSON file
$filename = 'userDomains/' . $username . '.json'; // File path with folder
$urls = readUrlsFromFile($filename);

// If a URL deletion request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url_to_remove'])) {
    $url_to_remove = $_POST['url_to_remove'];
    // Remove the URL from the array
    $key = array_search($url_to_remove, $urls);
    if ($key !== false) {
        unset($urls[$key]);
        // Write updated URLs to the JSON file
        writeUrlsToFile($filename, $urls);
   }
}

// Generate HTML table rows with updated status and buttons to remove URLs

$html .= "<thead class=\"thead-dark\">";
$html .= "<tr>";
$html .= "<th>Website</th>";
$html .= "<th colspan=\"2\" style=\"border-left: 1px solid #c5c5c5; border-right: 1px solid #c5c5c5;\">Status</th>";
$html .= "<th></th>";
$html .= "</tr>";
$html .= "</thead>";
$html .= "<tbody>";

if (empty($urls)) {
    $html .= "<tr><td colspan='3'>No logged domains</td></tr>";
} else {
    foreach ($urls as $url) {
        // Remove 'http://' and 'www.' prefixes from the URL
        $cleaned_url = str_replace(array('http://', 'https://', 'www.'), '', $url);
        
        $html .= "<tr>
                     <td style=\"border-right: 1px solid #ddd;\">{$cleaned_url}</td>
                     " . isWebsiteOnline($url) . "
                     <td style=\"text-align: center; width: 5%;\"><button class='btn btn-danger' onclick=\"removeUrl('{$url}')\">X</button></td>
                  </tr>";
    }
}

$html .= "</tbody>";


echo $html;
// Return the updated HTML table

?>

<script>
    function removeUrl(url) {
        if (confirm('Are you sure you want to remove this URL?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SERVER["PHP_SELF"]; ?>');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
               //     location.reload(); // Reload the page after successful removal
                } else {
                    alert('Failed to remove URL. Please try again later.');
                }
            };
            xhr.send('url_to_remove=' + encodeURIComponent(url));
        }
    }
</script>
