<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];


    // Fetch category details from the database
    $query = "SELECT * FROM categories WHERE category_id = :category_id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();

    $categoryDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($categoryDetails !== false && $categoryDetails !== null) {
        $response = array(
            'status' => 'success',
            'data' => $categoryDetails
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'An error occurred while fetching category details.'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing category_id parameter.'
    );
}

header('Content-Type: application/json');
echo json_encode($response);
