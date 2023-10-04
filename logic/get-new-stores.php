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

$query = "SELECT store_id, store_name, reg_date FROM stores WHERE approved = :data";
$params = array(':data' => 'false');
$data = $controller->getRecordsByValue($query, $params);

switch ($sparePartDetails) {
    case false:
        $response = array(
            'status' => 'error',
            'message' => 'An error occured while fetching stores.'
        );
        break;
    case null:
        $response = array(
            'status' => 'error',
            'message' => 'No stores'
        );
        break;
    default:
        $response = array(
            'status' => 'success',
            'message' => 'New stores fetched successfully.',
            'stores' => $data
        );
        break;
}

if (!headers_sent()) {
    echo json_encode($response);
}
