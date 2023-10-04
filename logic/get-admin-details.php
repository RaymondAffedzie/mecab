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
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if (isset($_GET['admin'])) {
    $admin = $_GET['admin'];

    // Fetch spare part details from the controller
    $query = "SELECT u.user_id, u.first_name, u.other_names, u.last_name, u.users_email, c.users_contact FROM users u 
              LEFT JOIN users_contact c ON u.user_id = c.users_id WHERE user_id = :user_id";
    $params = array(":user_id" => $admin);
    $adminDetails = $controller->getSingleRecordsByValue($query, $params);

    switch ($adminDetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetching Admin.',
                'redirect' => '../Admin/add-admin.php'
            );
            break;
        case null:
            $response = array(
                'status' => 'error',
                'message' => 'Admin not found.',
                'redirect' => '../Admin/add-admin.php'
            );
            break;
        default:
            $response = array(
                'status' => 'success',
                'data' => $adminDetails
            );
            break;
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing admin parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
