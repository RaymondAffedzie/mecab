<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "error-log.txt");
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

// Fetch spare parts from the database
$services = $controller->getServices();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Services fetched successfully.',
    'services' => $services
);

if (!headers_sent()) {
    echo json_encode($response);
}
