<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../controllers/storeController.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandName = ucwords(filter_input(INPUT_POST, 'brandName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    $controller = new storeController();

    $tableName = "car_brand";
    $data = array(
        'brand_name' => $brandName,
    );
    $columnName = 'brand_name';
    $value = $brandName;

    $result = $controller->insertWithCheckSingleFeild($data, $tableName, $columnName, $value);
    if ($result == 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Car brand saved successfully!',
            'redirect' => './Admin/index.php'
        );
    } else if ($result == 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'Car brand already exists!',
            'redirect' => './Admin/add-car-brand.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid action.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}

