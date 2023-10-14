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
$query = "SELECT order_id, transaction_reference, payment_status, payment_amount, payment_date, confirmation_status 
           FROM payments";
$payments = $controller->getRecords($query);

switch ($payments) {
    case false:
        $response = array(
            'status' => 'error',
            'message' => 'An error occured while fetching payments.'
        );
        break;
    case true:
        $response = array(
            'status' => 'success',
            'message' => 'Payments fetched successfully.',
            'data' => $payments
        );
        break;
    default:
        $response = array(
            'status' => 'error',
            'message' => 'Unknown error occured.'
        );
}

if (!headers_sent()) {
    echo json_encode($response);
}
