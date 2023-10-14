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
if (isset($_SESSION['userId'])) {

    $controller = new StoreController();

    $user = $controller->getUserDetails();
    $contact = $controller->getUserContact($_SESSION['userId'], null);

    if ($contact) {
        $user['users_contact'] = $contact['users_contact'];
    } else {
        $user['users_contact'] = '';
    }

    $response = array(
        'status' => 'success',
        'message' => 'User details fetched successfully.',
        'user' => $user
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Missing parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
