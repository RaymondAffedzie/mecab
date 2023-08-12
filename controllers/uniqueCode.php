<?php
function generate_unique_id($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $unique_id = '';

    // Choose a random letter to be the first character of the unique ID
    $unique_id .= chr(rand(65, 90));

    for ($i = 1; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $unique_id .= $characters[$index];
    }

    return $unique_id;
}
$unique_id = generate_unique_id();

// echo $unique_id;


// generate uuid v4 string
function generate_uuid_v4()
{
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$v4uuid = generate_uuid_v4();
// echo "Version 4 uuid : " . $v4uuid;
