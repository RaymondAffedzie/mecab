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
$controller = new storeController();

if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];

     // Fetch spare part details from the controller
     $query = "SELECT * FROM car_model WHERE car_brand_id = :brand_id";
     $params = array(":brand_id" => $brand_id);
     $models = $controller->getRecordsByValue($query, $params);

     switch ($models) {
         case 'false':
             $response = array(
                 'status' => 'error',
                 'message' => 'An error occured while fetching car brands.',
             );
             break;
         case null:
             $response = array(
                 'status' => 'error',
                 'message' => 'Car brand not found.' . $brand_id,
             );
             break;
         default:
             $response = array(
                 'status' => 'success',
                 'data' => $models
             );
             break;
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing car_model_id parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
