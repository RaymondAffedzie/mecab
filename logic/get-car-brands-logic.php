<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
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
$storeController = new storeController();

// Fetch the car brands from the database
$carBrands = $storeController->getCarBrands();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Car brands fetched successfully.',
    'car_brands' => $carBrands
);

if (!headers_sent()) {
    echo json_encode($response);
}
