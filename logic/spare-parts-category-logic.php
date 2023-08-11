<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "Error: [$errno] $errstr - $errfile:$errline - [Date/time] - $eventDate";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}


require_once '../controllers/storeController.php';
$storeController = new storeController();

// Fetch the categories from the database
$categories = $storeController->getCategories();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Categories fetched successfully.',
    'categories' => $categories
);

if (!headers_sent()) {
    header('Content-Type: application/json');
    echo json_encode($response);
}