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

// Check if the logout action is requested
if (isset($_POST['action']) && $_POST['action'] == "logout") {

    if ($_SESSION['role'] != "Customer") {
        // Destroy the session
        session_destroy();

        // Prepare the response
        $response = array(
            'status' => 'success',
            'message' => 'Logout successful',
            'redirect' => './../index.php'
        );
    } else {
        // Destroy the session
        session_destroy();

        // Prepare the response
        $response = array(
            'status' => 'success',
            'message' => 'Logout successful',
            'redirect' => './index.php'
        );
    }
} else {
    // Invalid request
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request'
    );
}

// Send the JSON response

if (!headers_sent()) {
    echo json_encode($response);
}
