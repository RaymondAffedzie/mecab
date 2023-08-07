<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../controllers/storeController.php';

// Check if the form was submitted
if (isset($_POST['action']) && $_POST['action'] == "add_car_model") {
    $modelName = ucwords(filter_input(INPUT_POST, 'modelName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $car_brand_id = filter_input(INPUT_POST, 'car_brand_id', FILTER_SANITIZE_NUMBER_INT);

    $controller = new storeController();

    $tableName = 'car_model';
    $data = array(
        'model_name' => $modelName,
        'car_brand_id' => $car_brand_id,
        // Add more column-value pairs as needed
    );

    $result = $controller->insertWithCheckMultipleCheck($data, $tableName);
    if ($result == 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Car model saved successfully.',
            'redirect' => './index.php'
        );
    } else if ($result == 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'Car model already exists.'
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
