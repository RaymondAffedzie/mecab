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
    $brandName = ucwords(filter_input(INPUT_POST, 'brandName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    $controller = new storeController();

    $tableName = "car_brand";
    $data = array(
        'brand_name' => $brandName,
    );
    $columnName = 'brand_name';
    $value = $brandName;

    $result = $controller->addRecordBySingleVerification($data, $tableName, $columnName, $value);
    if ($result == 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Car brand saved successfully!',
            'redirect' => '../Admin/add-car-brand.php'
        );
    } else if ($result == 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'Car brand already exists!',
            'redirect' => '../Admin/add-car-brand.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid Request.',
        'redirect' => '../Admin/add-car-brand.php'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}

