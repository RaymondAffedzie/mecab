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
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (isset($order)) {
        $controller = new StoreController();
        $data = array(
            'status' => 'completed'
        );
        $table = 'orders';
        $dataKey = 'order_id';
        $success = $controller->updateRecord($table, $data, $dataKey, $order);
        switch ($success) {
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'Order completed successfully!',
                    'redirect' => '../Spare-parts/order-details.php?order='.$order
                );
                break;
            case 'failed':
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to complete order!'
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while completing order!'
                );
                break;
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Your request cannot be processed!'
        ];
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
