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

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';
require_once '../controllers/uniqueCode.php';
$controller = new storeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    $cartTotal = 0;
    foreach ($cartItems as $item) {
        $cartTotal += $item['subtotal'];
    }

    $cartDetails = [
        'cart' => $cartItems,
        'cart_total' => $cartTotal
    ];
    
    $orderId = generate_uuid_v4();
    $userId = $_SESSION['userId'];
    $orderDate = date("Y-m-d H:i:s");
    $totalAmount = $cartDetails['cart_total'];

    // Additional order details from the user
    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $gpsAddress = filter_input(INPUT_POST, 'gps_address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $region = filter_input(INPUT_POST, 'region', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $errors = array();
    if (empty($contact)) {
        $errors['contact'] = 'Your phone number for transaction is required.';
    } elseif (!preg_match('/^0[0-9]{9}$/', $contact)) {
        $errors['contact'] = 'Please enter a valid contact number starting with 0 and containing 10 digits.';
    }
    if (!empty($gpsAddress) && !preg_match('/^[a-zA-Z]{2}-\d{3,4}-\d{3,4}$/', $gpsAddress)) {
        $errors['gps_address'] = "Enter a valid GPS address. E.g: 'CE-301-4324'.";
    }
    if (empty($city)) {
        $errors['city'] = 'Your city or town for delivery is required.';
    }
    if (empty($region) || $region === 'Select Region') {
        $errors['region'] = 'Select region of your city or town.';
    }

    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation errors ',
            'errors' => $errors
        );
    } else {
        if (!empty($cartDetails)) {
            $tableName = 'orders';
            $data = [
                'order_id' => $orderId,
                'customer_id' => $userId,
                'order_date' => $orderDate,
                'total_amount' => $totalAmount,
                'contact' => $contact,
                'gps_address' => $gpsAddress,
                'city' => $city,
                'region' => $region
            ];

            // Insert order details into the orders table
            $controller->addRecord($data, $tableName);

            // Insert order items into the order_items table
            $tableName = 'order_items';
            foreach ($cartDetails['cart'] as $cartItem) {
                $orderItemData = [
                    'order_id' => $orderId,
                    'product_id' => $cartItem['id'],
                    'quantity' => $cartItem['quantity'],
                    'item_price' => $cartItem['price'],
                    'subtotal' => $cartItem['subtotal']
                ];
                $controller->addRecord($orderItemData, $tableName);
            }

            $response = array(
                'status' => 'success',
                'message' => 'Order successfully saved.',
                'id' => $orderId
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'You have an empty cart.'
            );
        }
    }
   
}  else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}