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
require_once '../controllers/storeController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionReference = filter_input(INPUT_POST, 'transaction_reference', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // verify payment
    $payment = new Payment();
    $paymentResult = $payment->verifyPayment($transactionReference);

    if ($paymentResult['status'] === 'success') {
        // Update order status
        $controller = new storeController();
        $orderData = array(
            'status' => 'payment received'
        );
        $orderTable = 'orders';
        $orderDataKey = 'order_id';
        $orderKey =  $paymentResult['data']['data']['reference'];
        $controller->updateRecord($orderTable, $orderData, $orderDataKey, $orderKey);

        // Save payment details
        $paymentData = array(
            'order_id' => $orderKey,
            'transaction_reference' => $transactionReference,
            'payment_status' => 'completed',
            'payment_amount' => $_SESSION['cart_total'],
            'payment_date' => date("Y-m-d H:i:s")
        );
        $paymentTable = 'payments';
        $controller->addRecord($paymentData, $paymentTable);

        $response = array(
            'status' => 'success',
            'message' => $paymentResult['message']
        );
    } else {
        // Payment verification failed
        $response = array(
            'status' => 'error',
            'message' => $paymentResult['message']
        );
    }
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
