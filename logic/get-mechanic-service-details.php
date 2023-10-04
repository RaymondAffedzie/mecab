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

if (isset($_GET['service'])) {
    $service = $_GET['service'];

    // Fetch spare part details from the controller
    $query = "SELECT * FROM mechanic_services WHERE service_id = :service_id";
    $params = array(":service_id" => $service);
    $serviceDetails = $controller->getSingleRecordsByValue($query, $params);

    switch ($serviceDetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetching services.',
                'redirect' => '../Mechanic/add-service.php'
            );
            break;
        case null:
            $response = array(
                'status' => 'error',
                'message' => 'Service not found.',
                'redirect' => '../Mechanic/add-service.php'
            );
            break;
        default:
            $response = array(
                'status' => 'success',
                'data' => $serviceDetails
            );
            break;
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing service parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
