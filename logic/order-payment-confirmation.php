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

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (isset($order)) {
        $controller = new StoreController();

        $query = 'SELECT p.payment_amount, o.total_amount FROM orders o INNER JOIN payments p ON o.order_id = p.order_id WHERE o.order_id = :order LIMIT 1';
        $params = [':order' => $order];
        $data = $controller->getSingleRecordsByValue($query, $params);

        if ($data['payment_amount'] == $data['total_amount']) {
            $dataKey = 'order_id';

            // update payment confirmation
            $data1 = [
                'confirmation_status' => 'true'
            ];
            $table1 = 'payments';
            $confirm = $controller->updateRecord($table1, $data1, $dataKey, $order);

            // update order status
            $data2 = [
                'status' => 'confirmed'
            ];
            $table2 = 'orders';
            $success = $controller->updateRecord($table2, $data2, $dataKey, $order);

            switch ($success) {
                case true:
                    $response = [
                        'status' => 'success',
                        'message' => 'Order confirmed successfully!',
                        'redirect' => '../Spare-parts/order-details.php?order=' . $order
                    ];
                    break;
                case 'failed':
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to confirm order!'
                    ];
                    break;
                default:
                    $response = [
                        'status' => 'error',
                        'message' => 'An error occurred while confirming order!'
                    ];
                    break;
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Orders total amount is not equal to the customers payment.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Your request cannot be processed!' . $order
        ];
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
