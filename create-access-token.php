<?php
require_once 'create-apikey.php';

$url = 'https://sandbox.momodeveloper.mtn.com/collection/token/';

// Prepare cURL request
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

# Request headers
$headers = array(
    'Authorization: Basic ' . base64_encode($v4uuid . ':' . $apiKey),
    'Ocp-Apim-Subscription-Key: '.$pk,
    'Content-Type: application/json',
    'Content-Length: 0', 
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Execute the request
$resp = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
} else {
    // Check the HTTP status code
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);


    if ($httpCode === 200) {
        // Success: Access token created
        $respData = json_decode($resp);
        $accessToken = $respData->access_token;
        // echo $accessToken . "<br><br><br>";
    } elseif ($httpCode === 401) {
        $errorResponse = json_decode($resp, true);
        echo 'Unauthorized: ' . $errorResponse['error'] . PHP_EOL;
    } else {
        echo 'HTTP Status Code: ' . $httpCode . PHP_EOL;
        echo 'Response: ' . $resp . PHP_EOL;
    }
}

// Close the cURL session
curl_close($curl);
?>
