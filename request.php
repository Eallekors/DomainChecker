
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$site_url = 'https://womo.newwebtec.de'; // Site URL
$api_url = $site_url . '/wp-json';

// Make the request to the REST API
$response = file_get_contents( $api_url );

// Check for errors
if ( $response === false ) {
    echo 'Error: Unable to retrieve data from the API.';
} else {
    // Parse the JSON response
    $site_data = json_decode( $response );

    // Output site data
    if ( $site_data ) {
        echo 'Site URL: ' . $site_data->url . '<br>';
        echo 'Site Name: ' . $site_data->name . '<br>';
        // Output more information as needed
    } else {
        echo 'Failed to retrieve site data.';
    }
}
