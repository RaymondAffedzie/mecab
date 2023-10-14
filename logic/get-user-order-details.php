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
$controller = new storeController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order'])) {
        $order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Fetch spare part details from the controller
        $query = "SELECT o.order_id, o.order_date, o.total_amount, o.contact, o.city, o.region, o.gps_address, o.status, u.first_name, u.other_names, u.last_name, u.users_email, i.quantity, i.item_price, i.subtotal, s.name, s.image 
        FROM orders o 
        INNER JOIN users u ON o.customer_id = u.user_id
        INNER JOIN order_items i ON o.order_id = i.order_id
        INNER JOIN spare_parts s ON i.product_id = s.sparepart_id  WHERE o.order_id = :order_id";
        $params = array(":order_id" => $order);
        $orderDetails = $controller->getRecordsByValue($query, $params);

        // var_dump($orderDetails);
        switch ($orderDetails) {
            case null:
                $response = array(
                    'status' => 'error',
                    'message' => 'order not found.'
                );
                break;
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'Details fetched!',
                    'data' => $orderDetails
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occured while fetching orders details. Please reload try again!'
                );
                break;
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid request. Missing parameters.'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid Request.'
    );
}


if (!headers_sent()) {
    echo json_encode($response);
}
