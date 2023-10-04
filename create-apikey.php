<?php
require_once 'create-apiuser.php';
$url = "https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/".$v4uuid."/apikey";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

# Request headers
$headers = array(
    'Cache-Control: no-cache',
    'Ocp-Apim-Subscription-Key: '.$pk,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($request_body)
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_VERBOSE, true);

# Request body
$request_body = json_encode(array(
    'providerCallbackHost' => 'www.mecab.org' 
));
curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

# Basic authentication with Secret Key
curl_setopt($curl, CURLOPT_USERPWD, $pk.":");

$resp = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
} else {
    $data = json_decode($resp);
    $apiKey = $data->apiKey;
    // echo $apiKey;
}

curl_close($curl);
