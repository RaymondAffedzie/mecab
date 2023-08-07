<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
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
