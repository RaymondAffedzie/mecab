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
$controller = new storeController();

if (isset($_GET['specialisation'])) {
    $specialisation_id = filter_input(INPUT_GET, 'specialisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Fetch specialisation details from the controller
    $query = "SELECT * FROM specialisation WHERE specialisation_id = :specialisation_id LIMIT 1";
    $params = array(":specialisation_id" => $specialisation_id);
    $specialisationdetails = $controller->getSingleRecordsByValue($query, $params);

    switch ($specialisationdetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetching specialisation!'
            );
            break;
        case null:
            $response = array(
                'status' => 'error',
                'message' => 'Specialisation not found!'
            );
            break;
        case true:
            $response = array(
                'status' => 'success',
                'data' => $specialisationdetails
            );
            break;
        default:
            $response = array(
                'status' => 'error',
                'message' => 'Unknown error occured! Try again later!!!'
            );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing specialisation id parameter!'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
