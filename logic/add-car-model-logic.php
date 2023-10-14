<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:i:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelName = ucwords(filter_input(INPUT_POST, 'modelName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $car_brand_id = filter_input(INPUT_POST, 'car_brand_id', FILTER_SANITIZE_NUMBER_INT);

    $controller = new storeController();

    $tableName = 'car_model';
    $data = array(
        'model_name' => $modelName,
        'car_brand_id' => $car_brand_id,
        // Add more column-value pairs as needed
    );

    $result = $controller->addRecordByMultipleVerification($data, $tableName);
    if ($result == 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Car model saved successfully.',
            'redirect' => '../Admin/add-car-model.php'
        );
    } else if ($result == 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'Car model already exists.',
            'redirect' => '../Admin/add-car-model.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid action.',
        'redirect' => '../Admin/add-car-model.php'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
