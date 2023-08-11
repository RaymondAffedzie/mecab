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
$controller = new storeController();

if (isset($_GET['car_brand_id'])) {
    $car_brand_id = $_GET['car_brand_id'];

    // Fetch spare part details from the controller
    $query = "SELECT * FROM car_brand WHERE car_brand_id = :brand_id";
    $params = array(":brand_id" => $car_brand_id);
    $carBrandDetails = $controller->getSingleRecordsByValue($query, $params);

    switch ($carBrandDetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetching car brands.',
                'redirect' => '../Admin/add-car-brand.php'
            );
            break;
        case null:
            $response = array(
                'status' => 'error',
                'message' => 'Car brand not found.',
                'redirect' => '../Admin/add-car-brand.php'
            );
            break;
        default:
            $response = array(
                'status' => 'success',
                'data' => $carBrandDetails
            );
            break;
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing car_brand_id parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
