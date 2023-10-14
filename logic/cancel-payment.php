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
require_once '../controllers/storeController.php';
$controller = new storeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionReference = filter_input(INPUT_POST, 'ref', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // update order status
    $data = array(
        'status' => 'payment canceled'
    );

    // Database values
    $table = 'orders';
    $dataKey = 'order_id';
    $key =  $transactionReference;

    $controller->updateRecord($table, $data, $dataKey, $key);

    // save payment details
    $paymentData = array(
        'order_id' => $key,
        'transaction_reference' => $transactionReference,
        'payment_status' => 'failed',
        'payment_amount' => $_SESSION['cart_total'],
        'payment_date' => date("Y-m-d H:i:s")
    );

    $table = 'payments';
    $controller->addRecord($paymentData, $table);

    $response = array(
        'status' => 'success',
        'message' => 'Payment canceled.'
    );
} else {
    // Invalid request method
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
