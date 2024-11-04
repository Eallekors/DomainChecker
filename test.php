<?php
// Include Composer's autoloader
require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Create a Guzzle client instance
$client = new Client();

try {
    // Make a GET request to example.com
    $response = $client->get('http://example.com');

    // Get the response body
    $body = $response->getBody()->getContents();

    // Output the response body
    echo $body;
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Catch and handle any errors that occur during the request
    echo "Error: " . $e->getMessage();
}





