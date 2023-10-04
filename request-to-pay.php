<?php
// Include the file that generates the access token and other variables
require_once 'create-access-token.php';

// API endpoint URL
$url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay";

// Initialize cURL session
$curl = curl_init($url);

// Set cURL options
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Request headers
$headers = array(
    'Authorization: Bearer ' . $accessToken, // Replace with your access token
    'X-Reference-Id: ' . $v4uuid,      // Replace with your reference ID (UUID)
    'X-Target-Environment: sandbox',
    'Content-Type: application/json'
);

// Optional callback URL
$callbackUrl = 'https://www.mecab.org'; // Replace with your callback URL if needed
if ($callbackUrl) {
    $headers[] = 'X-Callback-Url: ' . $callbackUrl;
}

// Request body
$requestBody = json_encode(array(
    'amount' => '100',              // Replace with the desired amount
    'currency' => 'EUR',            // Replace with the desired currency
    'externalId' => '12345678',        // Replace with your external ID
    'payer' => array(
        'partyIdType' => 'MSISDN',  // Replace with the appropriate party ID type
        'partyId' => '0247692388' // Replace with the payer's account identifier
    ),
    'payerMessage' => 'Payment for something', // Replace with your message
    'payeeNote' => 'Note for payee',            // Replace with your note
));

$headers[] = 'Content-Length: ' . strlen($request_body);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $requestBody);

// Execute the cURL request
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    echo 'cURL error: ' . curl_error($curl);
} else {
    // Output the API response
    echo $response ;
    var_dump($headers);
}

// Close cURL session
curl_close($curl);
?>
