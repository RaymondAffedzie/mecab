<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imageData      = $_FILES['image'] ?? null;

    $category_name = ucwords($category_name);

    $errors = array();
    if (empty($category_name)) {
        $errors[] = "Category name is required.";
    }

    if (empty($imageData)) {
        $errors[] = "Category image is required.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        include_once "../controllers/uniqueCode.php";

        $category_id = $v4uuid;

        $storeController = new StoreController();

        $table = 'categories';
        $data = array(
            'category_name' => ucfirst($category_name)
        );

        $result = $storeController->addRecordWithImage($data, $imageData, $table);

        if ($result['status'] === 'success') {
            $response = array(
                'status' => 'success',
                'message' => $result['message'],
                'redirect' => '../Admin/categories.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' =>  $result['message'],
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
