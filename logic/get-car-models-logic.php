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
$storeController = new storeController();

if (isset($_GET['car_brand_id'])) {
    $carBrandId = $_GET['car_brand_id'];
    $carModels = $storeController->getCarModelsByBrand($carBrandId);

    $response = array(
        'status' => 'success',
        'message' => 'Car models fetched successfully.',
        'car_models' => $carModels
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
