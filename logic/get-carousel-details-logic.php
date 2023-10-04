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

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if (isset($_GET['carousel'])) {
    $carousel_id = filter_input(INPUT_GET, 'carousel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Fetch spare part details from the controller
    $query = "SELECT * FROM carousel WHERE carousel_id = :carousel_id LIMIT 1";
    $params = array(":carousel_id" => $carousel_id);
    $carouseldetails = $controller->getSingleRecordsByValue($query, $params);

    switch ($carouseldetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetching carousel.'
            );
            break;
        case null:
            $response = array(
                'status' => 'error',
                'message' => 'Carousel not found.'
            );
            break;
        default:
            $response = array(
                'status' => 'success',
                'data' => $carouseldetails
            );
            break;
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing carousel id parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
