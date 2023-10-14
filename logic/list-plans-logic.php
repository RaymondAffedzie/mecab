<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");
require_once '../controllers/payment.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $payment = new Payment();
    $plans = $payment->listPlans();

    if ($plans['status'] == true) {
        
        $response = array(
            'status' => 'success',
            'message' => $plans['message'],
            'data' => $plans['data']['data']
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => $plans['message']
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
