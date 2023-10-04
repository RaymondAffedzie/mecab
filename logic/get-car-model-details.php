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
$controller = new storeController();

if (isset($_GET['model'])) {
    $model = $_GET['model'];

     // Fetch spare part details from the controller
     $query = "SELECT m.car_model_id, m.model_name, b.brand_name
      FROM car_model m 
      LEFT JOIN car_brand b ON m.car_brand_id = b.car_brand_id 
      WHERE car_model_id = :model";
     $params = array(":model" => $model);
     $models = $controller->getRecordsByValue($query, $params);

     switch ($models) {
         case 'false':
             $response = array(
                 'status' => 'error',
                 'message' => 'An error occured while fetching car model.',
             );
             break;
         case null:
             $response = array(
                 'status' => 'error',
                 'message' => 'Car model not found.',
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
