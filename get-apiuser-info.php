<?php
require_once 'create-apikey.php';
$url = "https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/".$v4uuid;
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

# Request headers
$headers = array(
    'Cache-Control: no-cache',
    'Ocp-Apim-Subscription-Key: '. $pk,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$resp = curl_exec($curl);

$info = curl_getinfo($curl); 

curl_close($curl);

// var_dump($resp);

if ($info["http_code"] == 200) {
    echo "API User information OK. HTTP status code: " . $info["http_code"] . "\n";
} else {
    echo "Failed to get API User information. HTTP status code: " . $info["http_code"] . "\n";
    // You can also inspect the response body if available using: $resp
}
