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
require_once '../controllers/uniqueCode.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = ucwords(filter_input(INPUT_POST, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $price = ucwords(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT));
    $duration = ucwords(filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT));
    $user = $_SESSION['userId'];
    $controller = new storeController();
    $service_id = generate_uuid_v4();
    $tableName = "mechanic_services";
    $data = array(
        'service_id' => $service_id,
        'service_name' => $service,
        'price' => $price,
        'duration' => $duration,
        'users_id' => $user
    );
    $columnName = 'service_name';
    $value = $service;

    $result = $controller->addRecordBySingleVerification($data, $tableName, $columnName, $value);
    if ($result == 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Service saved successfully!',
            'redirect' => '../Mechanic/add-service.php'
        );
    } else if ($result == 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'Service already exists!'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid Request.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
