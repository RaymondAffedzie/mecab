<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "Error: [$errno] $errstr - $errfile:$errline - [Date/time] - $eventDate";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
// Create an instance of the StoreController class
$controller = new StoreController();

// Fetch car brands from the database
$query = "SELECT m.car_model_id, m.model_name, b.brand_name 
            FROM car_model m 
            JOIN car_brand b ON m.car_brand_id = b.car_brand_id";
$models = $controller->getRecords($query);

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Car Models fetched successfully.',
    'parts' => $models
);

if (!headers_sent()) {
    echo json_encode($response);
}
