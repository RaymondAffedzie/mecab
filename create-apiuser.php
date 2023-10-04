<?php
require_once 'controllers/uniqueCode.php';
$v4uuid = generate_uuid_v4();
$identifier = externalID();
$pk = '1c8c82ef55e447f6967363bab0aaf84f ';
$sk =  'bedb7741e5e34e27adcbea4266d2e628';
$url = "https://sandbox.momodeveloper.mtn.com/v1_0/apiuser";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

# Request headers
$headers = array(
    'X-Reference-Id: '.$v4uuid,
    'Content-Type: application/json',
    'Cache-Control: no-cache',
    'Ocp-Apim-Subscription-Key: '. $pk
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

# Request body
$request_body = json_encode(array(
    'providerCallbackHost' => 'www.mecab.org' 
));
curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

$resp = curl_exec($curl);

// var_dump($resp);

if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
}

$info = curl_getinfo($curl);
curl_close($curl);
// var_dump($info);

if ($info["http_code"] == 201) {
    // echo "API User successfully created. \n";
} else {
    echo "API User creation failed. HTTP status code: " . $info["http_code"]. "\n";
    // You can also inspect the response body if available using: $resp
}