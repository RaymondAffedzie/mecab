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
$controller = new StoreController();
$user = $_SESSION['userId'];
$query = "SELECT `service_name`, price, duration, service_id FROM mechanic_services WHERE users_id = :user";
$params = array(":user" => $user);
$services = $controller->getRecordsByValue($query, $params);

switch ($services) {
    case false:
        $response = array(
            'status' => 'error',
            'message' => 'An error occured while fetching user\' services!'
        );
        break;
    case null:
        $response = array(
            'status' => 'error',
            'message' => 'Mechanic has no services!'
        );
        break;
    case true:
        $response = array(
            'status' => 'success',
            'message' => 'Services fetched successfully.',
            'data' => $services
        );
        break;
        default:
        $response = array(
            'status' => 'error',
            'message' => 'Unknown error occured.',
        );
        
}

if (!headers_sent()) {
    echo json_encode($response);
}
