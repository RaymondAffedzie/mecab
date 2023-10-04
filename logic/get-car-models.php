<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:i:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';

$controller = new StoreController();

$query = "SELECT m.car_model_id, m.model_name, b.brand_name 
            FROM car_model m 
            JOIN car_brand b ON m.car_brand_id = b.car_brand_id";
$models = $controller->getRecords($query);
$response = array(
    'status' => 'success',
    'message' => 'Car Models fetched successfully.',
    'parts' => $models
);

if (!headers_sent()) {
    echo json_encode($response);
}
