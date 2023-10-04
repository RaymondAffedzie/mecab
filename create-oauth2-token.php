<?php
require_once 'create-apikey.php';
// Your API user ID and API key
$apiUserId = $v4uuid;

// API endpoint URL
$url = "https://sandbox.momodeveloper.mtn.com/collection/oauth2/token/";

// Encode the API user ID and API key as Basic Authentication
$authHeader = base64_encode("$apiUserId:$apiKey");

// Initialize cURL session
$curl = curl_init($url);

// Set cURL options
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Request headers
$headers = array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic ' . $authHeader,
    'Cache-Control: no-cache',
    'Ocp-Apim-Subscription-Key: '.$pk,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Request body
$request_body = 'grant_type=urn:openid:params:grant-type:ciba&auth_req_id=YOUR_AUTH_REQ_ID';
// Replace 'YOUR_AUTH_REQ_ID' with the actual authentication request ID

curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

// Execute the cURL request
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    echo 'cURL error: ' . curl_error($curl);
} else {
    // Output the API response (OAuth2 token)
    echo $response;
}

// Close cURL session
curl_close($curl);
?>
